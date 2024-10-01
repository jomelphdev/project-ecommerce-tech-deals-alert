<?php

defined( 'ABSPATH' ) or exit;

class PW_Gift_Cards_REST_Controller extends WP_REST_Controller {

    protected $namespace = 'wc-pimwick/v1';

    protected $rest_base = 'pw-gift-cards';

    public function register_routes() {

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/schema',
            array(
                'methods'  => WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_public_item_schema' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
            )
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_items' ),
                    'permission_callback' => array( $this, 'get_items_permissions_check' ),
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::READABLE ),
                ),
                array(
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => array( $this, 'create_item' ),
                    'permission_callback' => array( $this, 'create_item_permissions_check' ),
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
                ),
                'schema' => array( $this, 'get_public_item_schema' ),
            )
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            array(
                'args'   => array(
                    'id' => array(
                        'description' => __( 'Unique identifier for the gift card.', 'pw-woocommerce-gift-cards' ),
                        'type'        => 'integer',
                    ),
                ),
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_item' ),
                    'permission_callback' => array( $this, 'get_item_permissions_check' ),
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::READABLE ),
                ),
                array(
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => array( $this, 'update_item' ),
                    'permission_callback' => array( $this, 'update_item_permissions_check' ),
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                ),
                array(
                    'methods'             => WP_REST_Server::DELETABLE,
                    'callback'            => array( $this, 'delete_item' ),
                    'permission_callback' => array( $this, 'delete_item_permissions_check' ),
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::DELETABLE ),
                ),
                'schema' => array( $this, 'get_public_item_schema' ),
            )
        );
    }

    public function get_items( $request ) {
        global $wpdb;

        $params = $request->get_params();

        $number_where = '';
        $number = trim( $this->get_param_value( $params, 'number' ) );
        if ( !empty( $number ) ) {
            $number_where = 'AND gift_card.number = %s';
        }

        $limit = absint( $this->get_param_value( $params, 'limit' ) );
        if ( empty( absint( $limit ) ) ) {
            $limit = PWGC_ADMIN_MAX_ROWS;
        }

        $sql = "
            SELECT
                gift_card.*,
                (SELECT SUM(amount) FROM {$wpdb->pimwick_gift_card_activity} AS a WHERE a.pimwick_gift_card_id = gift_card.pimwick_gift_card_id) AS balance
            FROM
                `{$wpdb->pimwick_gift_card}` AS gift_card
            WHERE
                gift_card.active = true
                $number_where
            ORDER BY
                gift_card.create_date DESC,
                gift_card.pimwick_gift_card_id DESC
            LIMIT
                $limit
        ";
        if ( !empty( $number_where ) ) {
            $sql = $wpdb->prepare( $sql, $number );
        }

        $results = $wpdb->get_results( $sql );

        $data = array();

        if ( $results !== null ) {
            foreach ( $results as $row ) {
                $itemdata = $this->prepare_item_for_response( $row, $request );
                $data[] = $this->prepare_response_for_collection( $itemdata );
            }
        }

        $data = apply_filters( 'pwgc_rest_api_response_get_items', $data );

        return new WP_REST_Response( $data, 200 );
    }

    private function get_param_value( $params, $key ) {
        if ( !empty( $params ) && isset( $params[ $key ] ) ) {
            return $params[ $key ];
        }

        return false;
    }

    public function get_item( $request ) {
        $params = $request->get_params();

        $id = $this->get_param_value( $params, 'id' );
        $id = absint( $id );

        $gift_card = PW_Gift_Card::get_by_id( $id );

        if ( !empty( $gift_card ) ) {
            $data = $this->prepare_item_for_response( $gift_card, $request );
            $activity = $this->prepare_activity_for_response( $gift_card, $request );

            $data = array(
                'gift_card' => $data,
                'activity' => $activity,
            );

            $data = apply_filters( 'pwgc_rest_api_response_get_item', $data );

            return new WP_REST_Response( $data, 200 );
        } else {
            return new WP_Error( '001', __( 'Gift Card Not Found', 'pw-woocommerce-gift-cards' ) );
        }
    }

    public function create_item( $request ) {
        global $pw_gift_cards;
        global $pw_gift_card_design_id;

        $params = $request->get_params();

        $number = trim( wc_clean( $this->get_param_value( $params, 'number' ) ) );
        $quantity = absint( $this->get_param_value( $params, 'quantity' ) );
        $amount = wc_clean( $this->get_param_value( $params, 'amount' ) );
        $expiration_date = wc_clean( $this->get_param_value( $params, 'expiration_date' ) );
        $send_email = boolval( $this->get_param_value( $params, 'send_email' ) );
        $recipient_email = wc_clean( $this->get_param_value( $params, 'recipient_email' ) );
        $from = wc_clean( $this->get_param_value( $params, 'from' ) );
        $note = wc_clean( $this->get_param_value( $params, 'note' ) );
        $pw_gift_card_design_id = absint( $this->get_param_value( $params, 'design_id' ) );

        if ( !empty( $expiration_date ) ) {
            $date_array = date_parse( $expiration_date );
            if ( $date_array !== false ) {
                $expiration_date = date('Y-m-d H:i:s', mktime( $date_array['hour'], $date_array['minute'], $date_array['second'], $date_array['month'], $date_array['day'], $date_array['year'] ));
            }
        }

        $gift_cards = array();

        if ( !empty( $number ) ) {
            $existing = new PW_Gift_Card( $number );
            if ( !$existing->get_id() ) {
                $gift_cards[] = PW_Gift_Card::add_card( $number, $note );
            } else {
                return new WP_Error( '003', sprintf( __( 'Gift Card Number %s already exists.', 'pw-woocommerce-gift-cards' ), $number ) );
            }
        } else {
            for ( $x = 0; $x < max( $quantity, 1 ); $x++ ) {
                $gift_cards[] = PW_Gift_Card::create_card( $note );
            }
        }

        foreach ( $gift_cards as $gift_card ) {
            if ( !empty( $amount ) && $amount > 0 ) {
                $gift_card->credit( $amount );
            }

            if ( !empty( $expiration_date ) ) {
                $gift_card->set_expiration_date( $expiration_date );
            }

            $gift_cards[] = $gift_card;

            if ( !empty( $recipient_email ) ) {
                $pw_gift_cards->set_current_currency_to_default();
                $gift_card->set_recipient_email( $recipient_email );

                if ( $send_email ) {
                    do_action( 'pw_gift_cards_send_email_manually', $gift_card->get_number(), $recipient_email, $from, '', $note, $amount, '' );
                }
            }

            $data = $this->prepare_item_for_response( $gift_card, $request );
            $activity = $this->prepare_activity_for_response( $gift_card, $request );

            $data = array(
                'gift_card' => $data,
                'activity' => $activity,
            );

            $results[] = apply_filters( 'pwgc_rest_api_response_create_item', $data );
        }

        return new WP_REST_Response( $results, 200 );
    }

    public function update_item( $request ) {
        global $pw_gift_cards;

        $params = $request->get_params();

        $id = $this->get_param_value( $params, 'id' );
        $id = absint( $id );

        $gift_card = PW_Gift_Card::get_by_id( $id );

        if ( !empty( $gift_card ) ) {

            $note = $this->get_param_value( $params, 'note' );
            $note = stripslashes( wc_clean( $note ) );

            if ( isset( $params['number'] ) ) {
                $number = $this->get_param_value( $params, 'number' );
                if ( ! $gift_card->set_number( $number ) ) {
                    return new WP_Error( '003', sprintf( __( 'Gift Card Number %s already exists.', 'pw-woocommerce-gift-cards' ), $number ) );
                }
            }

            // To reactivate a card, set the 'active' flag to a true value.
            if ( isset( $params['active'] ) ) {
                $active = $this->get_param_value( $params, 'active' );
                if ( boolval( $active ) ) {
                    $gift_card->reactivate( $note );
                } else {
                    $gift_card->deactivate( $note );
                }
            }

            if ( isset( $params['balance'] ) ) {
                $balance = $this->get_param_value( $params, 'balance' );
                $balance = $pw_gift_cards->sanitize_amount( $balance );
                $balance = floatval( $balance );

                if ( $balance >= 0 ) {
                    $adjustment_amount = $balance - $gift_card->get_balance();
                    if ( $adjustment_amount != 0 ) {
                        $gift_card->adjust_balance( $adjustment_amount, $note );
                    }
                } else {
                    return new WP_Error( '004', __( 'Balance must be zero or greater.', 'pw-woocommerce-gift-cards' ) );
                }

            } else {
                $amount = $this->get_param_value( $params, 'amount' );
                $amount = $pw_gift_cards->sanitize_amount( $amount );
                $amount = floatval( $amount );

                if ( !empty( $amount ) || ( !isset( $params['active'] ) && !empty( $note ) ) ) {
                    $gift_card->adjust_balance( $amount, $note );
                }
            }

            if ( isset( $params['expiration_date'] ) ) {
                $expiration_date = $this->get_param_value( $params, 'expiration_date' );
                $new_expiration_date = wc_clean( $expiration_date );
                if ( empty( $new_expiration_date ) ) {
                    $gift_card->set_expiration_date( null );
                } else {
                    $date_array = date_parse( $new_expiration_date );
                    if ( $date_array !== false ) {
                        $expiration_date = date('Y-m-d H:i:s', mktime( $date_array['hour'], $date_array['minute'], $date_array['second'], $date_array['month'], $date_array['day'], $date_array['year'] ));
                        $gift_card->set_expiration_date( $expiration_date );
                    } else {
                        return new WP_Error( '002', __( 'Unable to parse expiration date.', 'pw-woocommerce-gift-cards' ) );
                    }
                }
            }

            return $this->get_item( $request );
        } else {
            return new WP_Error( '001', __( 'Gift Card Not Found', 'pw-woocommerce-gift-cards' ) );
        }
    }

    public function delete_item( $request ) {
        global $pw_gift_cards;

        $params = $request->get_params();

        $id = $this->get_param_value( $params, 'id' );
        $id = absint( $id );

        $gift_card = PW_Gift_Card::get_by_id( $id );

        if ( !empty( $gift_card ) ) {
            if ( isset( $params['force'] ) && boolval( $params['force'] ) ) {
                $gift_card->delete();
                $data = array(
                    'number' => $gift_card->get_number(),
                    'deleted' => true,
                );

                $data = apply_filters( 'pwgc_rest_api_response_update_item', $data );

                return new WP_REST_Response( $data, 200 );
            } else {
                $gift_card->deactivate();
                return $this->get_item( $request );
            }
        } else {
            return new WP_Error( '001', __( 'Gift Card Not Found', 'pw-woocommerce-gift-cards' ) );
        }
    }

    public function get_endpoint_args_for_item_schema( $method = WP_REST_Server::CREATABLE ) {
        $args = array();

        switch ( $method ) {
            case WP_REST_Server::READABLE:
                $args = array(
                    'number' => array(
                        'type'          => 'string',
                        'description'   => __( 'The specific gift card number to retrieve.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'limit' => array(
                        'type'          => 'numeric',
                        'description'   => sprintf( __( 'The number of gift cards to retrieve. Default is %s', 'pw-woocommerce-gift-cards' ), PWGC_ADMIN_MAX_ROWS ),
                    ),
                );
            break;

            case WP_REST_Server::CREATABLE:
                $args = array(
                    'number' => array(
                        'type'          => 'string',
                        'description'   => __( 'The gift card number. Must not exist in the database already.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'quantity' => array(
                        'default'       => 1,
                        'type'          => 'numeric',
                        'description'   => __( 'The number of gift cards to generate. Ignored if the "number" parameter has a value.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'amount' => array(
                        'type'          => 'numeric',
                        'description'   => __( 'Initial gift card balance.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'expiration_date' => array(
                        'type'          => 'date',
                        'description'   => __( 'The expiration date for the gift card.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'send_email' => array(
                        'type'          => 'boolean',
                        'description'   => __( 'Set to a true value to email the gift card to the recipient_email specified.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'recipient_email' => array(
                        'type'          => 'string',
                        'description'   => __( 'The email address that will receive the gift card.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'from' => array(
                        'type'          => 'string',
                        'description'   => __( 'The friendly name of the person who sent the gift card to the recipient.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'note' => array(
                        'type'          => 'string',
                        'description'   => __( 'Adds a note to the gift card activity record when the gift card is created.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'design_id' => array(
                        'type'          => 'numeric',
                        'description'   => __( 'The database ID of the Email Design to use when sending the gift card.', 'pw-woocommerce-gift-cards' ),
                    ),
                );
            break;

            case WP_REST_Server::EDITABLE:
                $args = array(
                    'number' => array(
                        'type'          => 'string',
                        'description'   => __( 'Changes the gift card number to this value. Must not exist in the database already.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'amount' => array(
                        'type'          => 'numeric',
                        'description'   => __( 'Balance adjustment amount. Can be positive or negative.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'balance' => array(
                        'type'          => 'numeric',
                        'description'   => __( 'Set the balance to a specific value. This will add a transaction for the appropriate amount to set the balance to this value.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'note' => array(
                        'type'          => 'string',
                        'description'   => __( 'Adds a note to the gift card activity record.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'expiration_date' => array(
                        'type'          => 'date',
                        'description'   => __( 'The expiration date for the gift card. Send an empty value to clear the expiration date.', 'pw-woocommerce-gift-cards' ),
                    ),
                    'active' => array(
                        'type'          => 'boolean',
                        'description'   => __( 'Send a true value to deactivate the gift card. Send a false value to reactivate a previously deactivated gift card.', 'pw-woocommerce-gift-cards' ),
                    ),
                );
            break;

            case WP_REST_Server::DELETABLE:
                $args = array(
                    'force' => array(
                        'default'     => false,
                        'type'        => 'boolean',
                        'description' => __( 'Whether to bypass trash and force deletion.', 'pw-woocommerce-gift-cards' ),
                    ),
                );
            break;
        }

        return $args;
    }

    public function get_items_permissions_check( $request ) {
        return wc_rest_check_post_permissions( 'product', 'read' );
    }

    public function get_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    public function create_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    public function update_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    public function delete_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    protected function prepare_item_for_database( $request ) {
        return array();
    }

    public function prepare_item_for_response( $item, $request ) {
        if ( is_a( $item, 'PW_Gift_Card' ) ) {
            return array(
                'pimwick_gift_card_id'      => $item->get_id(),
                'number'                    => $item->get_number(),
                'active'                    => $item->get_active(),
                'create_date'               => $item->get_create_date() ,
                'expiration_date'           => $item->get_expiration_date(),
                'pimwick_gift_card_parent'  => $item->get_pimwick_gift_card_parent(),
                'recipient_email'           => $item->get_recipient_email(),
                'balance'                   => $item->get_balance(),
            );
        } else {
            return $item;
        }
    }

    public function prepare_activity_for_response( $gift_card, $request ) {
        if ( is_a( $gift_card, 'PW_Gift_Card' ) ) {

            $activity = array();

            foreach ( $gift_card->get_activity() as $record ) {
                $activity[] = array(
                    'pimwick_gift_card_activity_id' => $record->pimwick_gift_card_activity_id,
                    'activity_date'                 => $record->activity_date,
                    'action'                        => $record->action,
                    'user'                          => $record->user,
                    'user_email'                    => $record->user_email,
                    'amount'                        => $record->amount,
                    'note'                          => $record->note,
                );
            }

            return $activity;
        }

        return array();
    }
}

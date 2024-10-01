/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _woocommerce_blocks_registry__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @woocommerce/blocks-registry */ "@woocommerce/blocks-registry");
/* harmony import */ var _woocommerce_blocks_registry__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_woocommerce_blocks_registry__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _nmi_credit_card__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nmi-credit-card */ "./src/nmi-credit-card.js");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./utils */ "./src/utils.js");
var _getBlocksConfigurati, _getBlocksConfigurati2, _getBlocksConfigurati3;






const NMICreditCard = props => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_nmi_credit_card__WEBPACK_IMPORTED_MODULE_3__.CreditCardComponent, {
    ...props
  });
};
const nmiCCPaymentMethod = {
  name: _utils__WEBPACK_IMPORTED_MODULE_5__.PAYMENT_METHOD_NAME,
  label: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_utils__WEBPACK_IMPORTED_MODULE_5__.Label, null),
  content: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(NMICreditCard, null),
  edit: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(NMICreditCard, null),
  canMakePayment: () => true,
  ariaLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('NMI payment method', _utils__WEBPACK_IMPORTED_MODULE_5__.TEXT_DOMAIN),
  supports: {
    showSavedCards: (_getBlocksConfigurati = (0,_utils__WEBPACK_IMPORTED_MODULE_5__.getBlocksConfiguration)()?.showSavedCards) !== null && _getBlocksConfigurati !== void 0 ? _getBlocksConfigurati : false,
    showSaveOption: (_getBlocksConfigurati2 = (0,_utils__WEBPACK_IMPORTED_MODULE_5__.getBlocksConfiguration)()?.showSaveOption) !== null && _getBlocksConfigurati2 !== void 0 ? _getBlocksConfigurati2 : false,
    features: (_getBlocksConfigurati3 = (0,_utils__WEBPACK_IMPORTED_MODULE_5__.getBlocksConfiguration)()?.supports) !== null && _getBlocksConfigurati3 !== void 0 ? _getBlocksConfigurati3 : []
  }
};
(0,_woocommerce_blocks_registry__WEBPACK_IMPORTED_MODULE_1__.registerPaymentMethod)(nmiCCPaymentMethod);

/***/ }),

/***/ "./src/nmi-credit-card.js":
/*!********************************!*\
  !*** ./src/nmi-credit-card.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   CreditCardComponent: () => (/* binding */ CreditCardComponent)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _payment_processing__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./payment-processing */ "./src/payment-processing.js");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./utils */ "./src/utils.js");







/**
 * @description Credit Card Component for NMI payment gateway integration in woo commerece
 */
const CreditCardComponent = ({
  billing,
  eventRegistration,
  emitResponse,
  components
}) => {
  const cardIcons = (0,_utils__WEBPACK_IMPORTED_MODULE_5__.getCreditCardIcons)();
  const {
    onPaymentSetup,
    onCheckoutFail
  } = eventRegistration;
  const {
    PaymentMethodIcons,
    ValidationInputError,
    LoadingMask
  } = components;
  const [isWindowAvaialble, setIsWindowAvailable] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(false);
  const [collectJSLoading, setCollectJSLoading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(false);
  const [publicKey, setPublicKey] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)();
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    if (typeof window != undefined) {
      setIsWindowAvailable(true);
    }
    if (!publicKey) {
      const k = (0,_utils__WEBPACK_IMPORTED_MODULE_5__.getPublicKey)();
      setPublicKey(k ? k : null);
    }
  });
  const configureCollectJs = () => {
    try {
      if (window.CollectJS !== undefined) {
        setCollectJSLoading(true);
        window.CollectJS.configure({
          variant: 'inline',
          customCss: {
            height: '20px',
            'line-height': '20px',
            padding: '0px',
            'pointer-events': 'auto'
          },
          styleSniffer: 'true',
          fields: {
            ..._utils__WEBPACK_IMPORTED_MODULE_5__.PAYMENT_UI_FIELDS
          },
          validationCallback: function (field, status, message) {
            setCollectJSLoading(false);
            handleValidationErrors({
              field,
              status,
              message
            });
          },
          timeoutDuration: _utils__WEBPACK_IMPORTED_MODULE_5__.PAYMENT_TIMEOUT_DURATION,
          timeoutCallback: function () {},
          fieldsAvailableCallback: function () {
            setCollectJSLoading(false);
            window.collectResponse = '';
            window.effectTriggerTimes = 0;
          },
          callback: handleSubmission
        });
      } else {
        throw new Error((0,_utils__WEBPACK_IMPORTED_MODULE_5__.getBlocksConfiguration)()?.collect_js_error);
      }
    } catch (error) {
      document.querySelectorAll('.wc-block-nmi-gateway-container .wc-block-gateway-input, .wc-block-nmi-gateway-container label').forEach(el => {
        el.style.display = 'none';
      });
      var field = 'ccnumber',
        status = false,
        message = error.message;
      handleValidationErrors({
        field,
        status,
        message
      });
    }
  };
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    if (publicKey && publicKey.length > 0 && isWindowAvaialble) {
      configureCollectJs();
    }
  }, [publicKey]);

  //#region  On Submit
  const [collectResponse, setCollectResponse] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)('');
  const handleSubmission = response => {
    window.collectResponse = response;
    setCollectResponse(response.token);
  };

  //#endregion

  //#region Errors

  const onNMIError = (0,_payment_processing__WEBPACK_IMPORTED_MODULE_3__.usePaymentProcessing)(billing, emitResponse, onPaymentSetup, onCheckoutFail, collectResponse);
  //#endregion

  //#region Validator
  const [ccnumber, setccnumber] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)('');
  const [ccexp, setccexp] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)('');
  const [cccvv, setcccvv] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)('');
  const handleValidationErrors = response => {
    const {
      status,
      message,
      field
    } = response;
    setCollectJSLoading(false);
    if (field === 'ccnumber') {
      setccnumber(status ? '' : message);
    }
    if (field === 'ccexp') {
      setccexp(status ? '' : message);
    }
    if (field === 'cvv') {
      setcccvv(status ? '' : message);
    }
    if (status === false) {
      onNMIError(message);
    } else {
      if (ccnumber === '' && cccvv === '' && ccexp === '') {
        onNMIError('');
      }
    }
  };

  //#endregion

  //#region Field Render

  const CollectJSElements = () => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wc-block-card-elements wc-block-nmi-gateway-container"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wc-block-gateway-container wc-card-number-element"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    id: "nmi-card-number-element",
    className: "wc-block-gateway-input"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    htmlFor: "nmi-card-number-element"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Card Number', _utils__WEBPACK_IMPORTED_MODULE_5__.TEXT_DOMAIN)), ccnumber && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(ValidationInputError, {
    errorMessage: ccnumber
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wc-block-gateway-container wc-card-expiry-element"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    id: "nmi-card-expiry-element",
    className: "wc-block-gateway-input"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    htmlFor: "nmi-card-expiry-element"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Expiry Date', _utils__WEBPACK_IMPORTED_MODULE_5__.TEXT_DOMAIN)), ccexp && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(ValidationInputError, {
    errorMessage: ccexp
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wc-block-gateway-container wc-card-cvc-element"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    id: "nmi-card-cvc-element",
    className: "wc-block-gateway-input"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    htmlFor: "nmi-card-cvc-element"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Card Code (CVC)', _utils__WEBPACK_IMPORTED_MODULE_5__.TEXT_DOMAIN)), cccvv && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(ValidationInputError, {
    errorMessage: cccvv
  })));

  //#endregion

  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(LoadingMask, {
    isLoading: collectJSLoading,
    showSpinner: "true",
    screenReaderLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Loading payment fields…', _utils__WEBPACK_IMPORTED_MODULE_5__.TEXT_DOMAIN)
  }, publicKey ? CollectJSElements() : 'public key not available yet', PaymentMethodIcons && cardIcons.length && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(PaymentMethodIcons, {
    icons: cardIcons,
    align: "left"
  }));
};

/***/ }),

/***/ "./src/payment-processing.js":
/*!***********************************!*\
  !*** ./src/payment-processing.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   usePaymentProcessing: () => (/* binding */ usePaymentProcessing)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils */ "./src/utils.js");



/**
 *  @description Custom hook to manage the payment proccessing for NMI gateway.
 */
const usePaymentProcessing = (billing, emitResponse, onPaymentSetup, onCheckoutFail, collectResponse) => {
  const [error, setError] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const onNMIError = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)(message => {
    console.log('onNMIError :', message);
    setError(message);
    return message ? message : false;
  }, []);

  // hook into and register callbacks for events
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const waitForCollectJsToken = async () => {
      const tokenCheckInterval = 2000;
      while (!window.collectResponse || window.collectResponse.length < 5) {
        window.effectTriggerTimes = window.effectTriggerTimes + 1;
        if (window.effectTriggerTimes > _utils__WEBPACK_IMPORTED_MODULE_1__.PAYMENT_TIMEOUT_DURATION / tokenCheckInterval) {
          throw new Error((0,_utils__WEBPACK_IMPORTED_MODULE_1__.getBlocksConfiguration)()?.timeout_error);
        }
        await new Promise(res => setTimeout(res, tokenCheckInterval));
      }
    };
    const onSubmit = async () => {
      try {
        var _billingAddress$first, _billingAddress$last_;
        // if there's an error return that.
        if (error) {
          return {
            type: emitResponse.responseTypes.ERROR,
            message: error
          };
        }
        window.collectResponse = '';
        window.CollectJS.startPaymentRequest();
        await waitForCollectJsToken().catch(err => {
          console.error('waitForCollectJsToken error: ', err);
        });
        if (window.collectResponse && window.collectResponse.card.type != null) {
          if ((0,_utils__WEBPACK_IMPORTED_MODULE_1__.getBlocksConfiguration)()?.allowed_card_types.indexOf(window.collectResponse.card.type.replace('diners', 'diners-club')) === -1) {
            return {
              type: emitResponse.responseTypes.ERROR,
              message: (0,_utils__WEBPACK_IMPORTED_MODULE_1__.getBlocksConfiguration)()?.card_disallowed_error
            };
          }
        } else {
          return {
            type: emitResponse.responseTypes.ERROR,
            message: (0,_utils__WEBPACK_IMPORTED_MODULE_1__.getBlocksConfiguration)()?.timeout_error
          };
        }
        const billingAddress = billing.billingAddress;
        const nmiArgs = {
          nmi_token: window.collectResponse?.token,
          nmi_js_response: JSON.stringify(window.collectResponse)
        };
        return {
          type: emitResponse.responseTypes.SUCCESS,
          meta: {
            paymentMethodData: {
              ...nmiArgs,
              billing_email: billingAddress.email,
              billing_first_name: (_billingAddress$first = billingAddress?.first_name) !== null && _billingAddress$first !== void 0 ? _billingAddress$first : '',
              billing_last_name: (_billingAddress$last_ = billingAddress?.last_name) !== null && _billingAddress$last_ !== void 0 ? _billingAddress$last_ : '',
              paymentMethod: _utils__WEBPACK_IMPORTED_MODULE_1__.PAYMENT_METHOD_NAME,
              paymentRequestType: 'cc'
            },
            billingAddress
          }
        };
      } catch (e) {
        return {
          type: emitResponse.responseTypes.ERROR,
          message: e
        };
      }
    };
    const unsubscribeProcessing = onPaymentSetup(onSubmit);
    return () => {
      unsubscribeProcessing();
    };
  }, [onPaymentSetup, billing.billingAddress, onNMIError, error, emitResponse.noticeContexts.PAYMENTS, emitResponse.responseTypes.ERROR, emitResponse.responseTypes.SUCCESS, collectResponse]);

  // hook into and register callbacks for events.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const onError = ({
      processingResponse
    }) => {
      if (processingResponse?.paymentDetails?.errorMessage) {
        return {
          type: emitResponse.responseTypes.ERROR,
          message: processingResponse.paymentDetails.errorMessage,
          messageContext: emitResponse.noticeContexts.PAYMENTS
        };
      }
      // so we don't break the observers.
      return true;
    };
    const unsubscribeAfterProcessing = onCheckoutFail(onError);
    return () => {
      unsubscribeAfterProcessing();
    };
  }, [onCheckoutFail, emitResponse.noticeContexts.PAYMENTS, emitResponse.responseTypes.ERROR]);
  return onNMIError;
};

/***/ }),

/***/ "./src/utils.js":
/*!**********************!*\
  !*** ./src/utils.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Label: () => (/* binding */ Label),
/* harmony export */   PAYMENT_METHOD_NAME: () => (/* binding */ PAYMENT_METHOD_NAME),
/* harmony export */   PAYMENT_TIMEOUT_DURATION: () => (/* binding */ PAYMENT_TIMEOUT_DURATION),
/* harmony export */   PAYMENT_UI_FIELDS: () => (/* binding */ PAYMENT_UI_FIELDS),
/* harmony export */   TEXT_DOMAIN: () => (/* binding */ TEXT_DOMAIN),
/* harmony export */   getBlocksConfiguration: () => (/* binding */ getBlocksConfiguration),
/* harmony export */   getCreditCardIcons: () => (/* binding */ getCreditCardIcons),
/* harmony export */   getPublicKey: () => (/* binding */ getPublicKey)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _woocommerce_settings__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @woocommerce/settings */ "@woocommerce/settings");
/* harmony import */ var _woocommerce_settings__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_woocommerce_settings__WEBPACK_IMPORTED_MODULE_1__);


const PAYMENT_METHOD_NAME = 'nmi';
const TEXT_DOMAIN = 'wc-nmi';
const PAYMENT_TIMEOUT_DURATION = 20000;

/**
 * @description NMI Settings
 * @returns
 */
const getBlocksConfiguration = () => {
  const nmiServerData = (0,_woocommerce_settings__WEBPACK_IMPORTED_MODULE_1__.getSetting)(`${PAYMENT_METHOD_NAME}_data`, null);
  if (!nmiServerData) {
    throw new Error(`${PAYMENT_METHOD_NAME} initialization data is not available`);
  }
  return nmiServerData;
};

/**
 * ui elements
 * field_title attribute added to reference in other parts of the code
 */
const PAYMENT_UI_FIELDS = {
  ccnumber: {
    selector: `#${PAYMENT_METHOD_NAME}-card-number-element`,
    placeholder: '•••• •••• •••• ••••'
  },
  ccexp: {
    selector: `#${PAYMENT_METHOD_NAME}-card-expiry-element`,
    placeholder: getBlocksConfiguration()?.placeholder_expiry
  },
  cvv: {
    display: 'show',
    selector: `#${PAYMENT_METHOD_NAME}-card-cvc-element`,
    placeholder: getBlocksConfiguration()?.placeholder_cvc
  }
};

/**
 * @description Label for Payment Methods
 * @returns
 */
const Label = props => {
  var _getBlocksConfigurati;
  const {
    PaymentMethodLabel
  } = props.components;
  const labelText = (_getBlocksConfigurati = getBlocksConfiguration()?.title) !== null && _getBlocksConfigurati !== void 0 ? _getBlocksConfigurati : __('Credit / Debit Card', TEXT_DOMAIN);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(PaymentMethodLabel, {
    text: labelText
  });
};
const getPublicKey = () => {
  return getBlocksConfiguration()?.public_key;
};

/**
 * @description Payment options icons
 * @returns
 */
const getCreditCardIcons = () => {
  var _getBlocksConfigurati2;
  return Object.entries((_getBlocksConfigurati2 = getBlocksConfiguration()?.icons) !== null && _getBlocksConfigurati2 !== void 0 ? _getBlocksConfigurati2 : {}).map(([id, {
    src,
    alt
  }]) => {
    return {
      id,
      src,
      alt
    };
  });
};

//#endregion

/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@woocommerce/blocks-registry":
/*!******************************************!*\
  !*** external ["wc","wcBlocksRegistry"] ***!
  \******************************************/
/***/ ((module) => {

module.exports = window["wc"]["wcBlocksRegistry"];

/***/ }),

/***/ "@woocommerce/settings":
/*!************************************!*\
  !*** external ["wc","wcSettings"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wc"]["wcSettings"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkwp_nmi_gateway_pci_woocommerce"] = globalThis["webpackChunkwp_nmi_gateway_pci_woocommerce"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map
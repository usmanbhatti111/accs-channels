/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 43);
/******/ })
/************************************************************************/
/******/ ({

/***/ 43:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(44);


/***/ }),

/***/ 44:
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Authenticate = function () {
    function Authenticate(container) {
        _classCallCheck(this, Authenticate);

        this.container = $(container);

        this.container.find('#js-register-form').on('submit', this.registerHandler.bind(this));

        this.container.find('#js-login-form').on('submit', this.loginHandler.bind(this));
    }

    _createClass(Authenticate, [{
        key: 'loginHandler',
        value: function loginHandler(e) {
            e.preventDefault();

            $("#js-login-form button").hide();
            $("#js-login-form .deal-request-preloader").css('display', 'block');

            var thisForm = $(e.currentTarget);

            this.sendAjax(thisForm, 'login');
        }
    }, {
        key: 'registerHandler',
        value: function registerHandler(e) {
            e.preventDefault();

            $("#js-register-form button").hide();
            $("#js-register-form .deal-request-preloader").css('display', 'block');

            var thisForm = $(e.currentTarget);

            this.sendAjax(thisForm, 'register');
        }

        // регистрация прошла успешна

    }, {
        key: 'done',
        value: function done(data) {
            if (data.reload) {
                location.reload();
            } else if (data.two_factor) {
                $("#js-login-form .deal-request-preloader").hide();
                $("#js-login-form button").css('display', 'block');
                $("#js-login-form input[name='two_factor']").css('display', 'block');
                grecaptcha.reset(loginCaptcha);

                setNoty('We have sent you a confirmation code by email, enter it in the field that appears.', 'success', true);
            } else if (data.reg_confirmation) {
                $("#js-register-form .deal-request-preloader").hide();
                $("#js-register-form button").css('display', 'block');
                $("#js-register-form button").css('display', 'block');
                $("#email-confirmation-modal .confirm-submit__submit").attr('data-id', data.user_id);
                $("#email-confirmation-modal").modal('show');
            }
        }
    }, {
        key: 'failure',
        value: function failure(xhr) {
            var responseObject = JSON.parse(xhr.responseText);
            var errorMsg = [];

            $.each(responseObject, function (data, el) {
                if (Array.isArray(el)) {
                    errorMsg.push(el.pop());
                } else {
                    errorMsg.push(el);
                }
            });

            setNoty(errorMsg.join('\n'), 'error');

            grecaptcha.reset(registerCaptcha);
            grecaptcha.reset(loginCaptcha);
        }
    }, {
        key: 'sendAjax',
        value: function sendAjax(thisForm, type) {
            $.post(thisForm.attr('action'), thisForm.serialize()).done(this.done).fail(function () {
                if (type == 'register') {
                    $("#js-register-form .deal-request-preloader").hide();
                    $("#js-register-form button").css('display', 'block');
                } else if (type == 'login') {
                    $("#js-login-form .deal-request-preloader").hide();
                    $("#js-login-form button").css('display', 'block');
                }
            }, this.failure);
        }
    }]);

    return Authenticate;
}();

window.Authenticate = Authenticate;

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAgZWUxZGIwOWJjOGZiZTc4ZDMyMTQiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9sb2dpbl9yZWdpdGVyLmpzIl0sIm5hbWVzIjpbIkF1dGhlbnRpY2F0ZSIsImNvbnRhaW5lciIsIiQiLCJmaW5kIiwib24iLCJyZWdpc3RlckhhbmRsZXIiLCJiaW5kIiwibG9naW5IYW5kbGVyIiwiZSIsInByZXZlbnREZWZhdWx0IiwiaGlkZSIsImNzcyIsInRoaXNGb3JtIiwiY3VycmVudFRhcmdldCIsInNlbmRBamF4IiwiZGF0YSIsInJlbG9hZCIsImxvY2F0aW9uIiwidHdvX2ZhY3RvciIsImdyZWNhcHRjaGEiLCJyZXNldCIsImxvZ2luQ2FwdGNoYSIsInNldE5vdHkiLCJyZWdfY29uZmlybWF0aW9uIiwiYXR0ciIsInVzZXJfaWQiLCJtb2RhbCIsInhociIsInJlc3BvbnNlT2JqZWN0IiwiSlNPTiIsInBhcnNlIiwicmVzcG9uc2VUZXh0IiwiZXJyb3JNc2ciLCJlYWNoIiwiZWwiLCJBcnJheSIsImlzQXJyYXkiLCJwdXNoIiwicG9wIiwiam9pbiIsInJlZ2lzdGVyQ2FwdGNoYSIsInR5cGUiLCJwb3N0Iiwic2VyaWFsaXplIiwiZG9uZSIsImZhaWwiLCJmYWlsdXJlIiwid2luZG93Il0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7OztBQUdBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGFBQUs7QUFDTDtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLG1DQUEyQiwwQkFBMEIsRUFBRTtBQUN2RCx5Q0FBaUMsZUFBZTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFD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WCxDQUFpQkMsWUFBakI7QUFDSDs7O2lDQUVRVCxRLEVBQVU2QixJLEVBQUs7QUFDcEJ2QyxjQUFFd0MsSUFBRixDQUFPOUIsU0FBU1ksSUFBVCxDQUFjLFFBQWQsQ0FBUCxFQUFnQ1osU0FBUytCLFNBQVQsRUFBaEMsRUFDS0MsSUFETCxDQUNVLEtBQUtBLElBRGYsRUFFS0MsSUFGTCxDQUVVLFlBQVU7QUFDWixvQkFBR0osUUFBUSxVQUFYLEVBQXNCO0FBQ2xCdkMsc0JBQUUsMkNBQUYsRUFBK0NRLElBQS9DO0FBQ0FSLHNCQUFFLDBCQUFGLEVBQThCUyxHQUE5QixDQUFrQyxTQUFsQyxFQUE2QyxPQUE3QztBQUNILGlCQUhELE1BR00sSUFBRzhCLFFBQVEsT0FBWCxFQUFtQjtBQUNyQnZDLHNCQUFFLHdDQUFGLEVBQTRDUSxJQUE1QztBQUNBUixzQkFBRSx1QkFBRixFQUEyQlMsR0FBM0IsQ0FBK0IsU0FBL0IsRUFBMEMsT0FBMUM7QUFDSDtBQUNKLGFBVkwsRUFVTyxLQUFLbUMsT0FWWjtBQVlIOzs7Ozs7QUFHTEMsT0FBTy9DLFlBQVAsR0FBc0JBLFlBQXRCLEMiLCJmaWxlIjoiL2pzL2xvZ2luX3JlZ2l0ZXIuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHtcbiBcdFx0XHRcdGNvbmZpZ3VyYWJsZTogZmFsc2UsXG4gXHRcdFx0XHRlbnVtZXJhYmxlOiB0cnVlLFxuIFx0XHRcdFx0Z2V0OiBnZXR0ZXJcbiBcdFx0XHR9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSA0Myk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gd2VicGFjay9ib290c3RyYXAgZWUxZGIwOWJjOGZiZTc4ZDMyMTQiLCJjbGFzcyBBdXRoZW50aWNhdGVcbntcbiAgICBjb25zdHJ1Y3Rvcihjb250YWluZXIpe1xuICAgICAgICB0aGlzLmNvbnRhaW5lciA9ICQoY29udGFpbmVyKTtcblxuICAgICAgICB0aGlzLmNvbnRhaW5lci5maW5kKCcjanMtcmVnaXN0ZXItZm9ybScpLm9uKFxuICAgICAgICAgICAgJ3N1Ym1pdCcsXG4gICAgICAgICAgICB0aGlzLnJlZ2lzdGVySGFuZGxlci5iaW5kKHRoaXMpXG4gICAgICAgICk7XG5cbiAgICAgICAgdGhpcy5jb250YWluZXIuZmluZCgnI2pzLWxvZ2luLWZvcm0nKS5vbihcbiAgICAgICAgICAgICdzdWJtaXQnLFxuICAgICAgICAgICAgdGhpcy5sb2dpbkhhbmRsZXIuYmluZCh0aGlzKVxuICAgICAgICApO1xuICAgIH1cblxuICAgIGxvZ2luSGFuZGxlcihlKXtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICQoXCIjanMtbG9naW4tZm9ybSBidXR0b25cIikuaGlkZSgpO1xuICAgICAgICAkKFwiI2pzLWxvZ2luLWZvcm0gLmRlYWwtcmVxdWVzdC1wcmVsb2FkZXJcIikuY3NzKCdkaXNwbGF5JywgJ2Jsb2NrJyk7XG5cbiAgICAgICAgbGV0IHRoaXNGb3JtID0gJChlLmN1cnJlbnRUYXJnZXQpO1xuXG4gICAgICAgIHRoaXMuc2VuZEFqYXgodGhpc0Zvcm0sICdsb2dpbicpO1xuICAgIH1cblxuICAgIHJlZ2lzdGVySGFuZGxlcihlKXtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICQoXCIjanMtcmVnaXN0ZXItZm9ybSBidXR0b25cIikuaGlkZSgpO1xuICAgICAgICAkKFwiI2pzLXJlZ2lzdGVyLWZvcm0gLmRlYWwtcmVxdWVzdC1wcmVsb2FkZXJcIikuY3NzKCdkaXNwbGF5JywgJ2Jsb2NrJyk7XG5cbiAgICAgICAgbGV0IHRoaXNGb3JtID0gJChlLmN1cnJlbnRUYXJnZXQpO1xuXG4gICAgICAgIHRoaXMuc2VuZEFqYXgodGhpc0Zvcm0sICdyZWdpc3RlcicpO1xuICAgIH1cblxuICAgIC8vINGA0LXQs9C40YHRgtGA0LDRhtC40Y8g0L/RgNC+0YjQu9CwINGD0YHQv9C10YjQvdCwXG4gICAgZG9uZShkYXRhKXtcbiAgICAgICAgaWYoZGF0YS5yZWxvYWQpe1xuICAgICAgICAgICAgbG9jYXRpb24ucmVsb2FkKCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSBpZihkYXRhLnR3b19mYWN0b3IpXG4gICAgICAgIHtcbiAgICAgICAgICAgICQoXCIjanMtbG9naW4tZm9ybSAuZGVhbC1yZXF1ZXN0LXByZWxvYWRlclwiKS5oaWRlKCk7XG4gICAgICAgICAgICAkKFwiI2pzLWxvZ2luLWZvcm0gYnV0dG9uXCIpLmNzcygnZGlzcGxheScsICdibG9jaycpO1xuICAgICAgICAgICAgJChcIiNqcy1sb2dpbi1mb3JtIGlucHV0W25hbWU9J3R3b19mYWN0b3InXVwiKS5jc3MoJ2Rpc3BsYXknLCAnYmxvY2snKTtcbiAgICAgICAgICAgIGdyZWNhcHRjaGEucmVzZXQobG9naW5DYXB0Y2hhKTtcblxuICAgICAgICAgICAgc2V0Tm90eSgnV2UgaGF2ZSBzZW50IHlvdSBhIGNvbmZpcm1hdGlvbiBjb2RlIGJ5IGVtYWlsLCBlbnRlciBpdCBpbiB0aGUgZmllbGQgdGhhdCBhcHBlYXJzLicsICdzdWNjZXNzJywgdHJ1ZSk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSBpZihkYXRhLnJlZ19jb25maXJtYXRpb24pXG4gICAgICAgIHtcbiAgICAgICAgICAgICQoXCIjanMtcmVnaXN0ZXItZm9ybSAuZGVhbC1yZXF1ZXN0LXByZWxvYWRlclwiKS5oaWRlKCk7XG4gICAgICAgICAgICAkKFwiI2pzLXJlZ2lzdGVyLWZvcm0gYnV0dG9uXCIpLmNzcygnZGlzcGxheScsICdibG9jaycpO1xuICAgICAgICAgICAgJChcIiNqcy1yZWdpc3Rlci1mb3JtIGJ1dHRvblwiKS5jc3MoJ2Rpc3BsYXknLCAnYmxvY2snKTtcbiAgICAgICAgICAgICQoXCIjZW1haWwtY29uZmlybWF0aW9uLW1vZGFsIC5jb25maXJtLXN1Ym1pdF9fc3VibWl0XCIpLmF0dHIoJ2RhdGEtaWQnLCBkYXRhLnVzZXJfaWQpO1xuICAgICAgICAgICAgJChcIiNlbWFpbC1jb25maXJtYXRpb24tbW9kYWxcIikubW9kYWwoJ3Nob3cnKTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGZhaWx1cmUoeGhyKXtcbiAgICAgICAgbGV0IHJlc3BvbnNlT2JqZWN0ID0gSlNPTi5wYXJzZSh4aHIucmVzcG9uc2VUZXh0KTtcbiAgICAgICAgbGV0IGVycm9yTXNnID0gW107XG5cbiAgICAgICAgJC5lYWNoKHJlc3BvbnNlT2JqZWN0LCAoZGF0YSwgZWwpID0+IHtcbiAgICAgICAgICAgIGlmKEFycmF5LmlzQXJyYXkoZWwpKXtcbiAgICAgICAgICAgICAgICBlcnJvck1zZy5wdXNoKGVsLnBvcCgpKTtcbiAgICAgICAgICAgIH1lbHNle1xuICAgICAgICAgICAgICAgIGVycm9yTXNnLnB1c2goZWwpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgICAgICBzZXROb3R5KGVycm9yTXNnLmpvaW4oJ1xcbicpLCAnZXJyb3InKTtcblxuICAgICAgICBncmVjYXB0Y2hhLnJlc2V0KHJlZ2lzdGVyQ2FwdGNoYSk7XG4gICAgICAgIGdyZWNhcHRjaGEucmVzZXQobG9naW5DYXB0Y2hhKTtcbiAgICB9XG5cbiAgICBzZW5kQWpheCh0aGlzRm9ybSwgdHlwZSl7XG4gICAgICAgICQucG9zdCh0aGlzRm9ybS5hdHRyKCdhY3Rpb24nKSwgdGhpc0Zvcm0uc2VyaWFsaXplKCkpXG4gICAgICAgICAgICAuZG9uZSh0aGlzLmRvbmUpXG4gICAgICAgICAgICAuZmFpbChmdW5jdGlvbigpe1xuICAgICAgICAgICAgICAgIGlmKHR5cGUgPT0gJ3JlZ2lzdGVyJyl7XG4gICAgICAgICAgICAgICAgICAgICQoXCIjanMtcmVnaXN0ZXItZm9ybSAuZGVhbC1yZXF1ZXN0LXByZWxvYWRlclwiKS5oaWRlKCk7XG4gICAgICAgICAgICAgICAgICAgICQoXCIjanMtcmVnaXN0ZXItZm9ybSBidXR0b25cIikuY3NzKCdkaXNwbGF5JywgJ2Jsb2NrJyk7XG4gICAgICAgICAgICAgICAgfWVsc2UgaWYodHlwZSA9PSAnbG9naW4nKXtcbiAgICAgICAgICAgICAgICAgICAgJChcIiNqcy1sb2dpbi1mb3JtIC5kZWFsLXJlcXVlc3QtcHJlbG9hZGVyXCIpLmhpZGUoKTtcbiAgICAgICAgICAgICAgICAgICAgJChcIiNqcy1sb2dpbi1mb3JtIGJ1dHRvblwiKS5jc3MoJ2Rpc3BsYXknLCAnYmxvY2snKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9LCB0aGlzLmZhaWx1cmUpXG4gICAgICAgIDtcbiAgICB9XG59XG5cbndpbmRvdy5BdXRoZW50aWNhdGUgPSBBdXRoZW50aWNhdGU7XG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9sb2dpbl9yZWdpdGVyLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==
/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/utils.js":
/*!*******************************!*\
  !*** ./resources/js/utils.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ generateStarRating)\n/* harmony export */ });\nconsole.log(generateStarRating);\nfunction generateStarRating(inputSelector, starsDivSelector, spanStarSelector) {\n  console.log(\"generating star with generateStarRating(\".concat(inputSelector, \", \").concat(starsDivSelector, \", \").concat(spanStarSelector, \") from utils.mjs\"));\n  var spanStar = document.querySelector(spanStarSelector);\n\n  for (var i = 0; i < 5; i++) {\n    spanStarClone = spanStar.cloneNode(true);\n    spanStarClone.setAttribute(\"data-grade\", i + 1);\n    spanStarClone.textContent = \"★\";\n    spanStarClone.addEventListener(\"mouseover\", function (e) {\n      var starElements = document.querySelectorAll(spanStarSelector);\n      starElements.forEach(function (el) {\n        console.log(e.target.dataset.grade, el.dataset.grade);\n\n        if (el.dataset.grade <= e.target.dataset.grade) {\n          el.classList.add(\"hovered-star\");\n        } else {\n          el.classList.remove(\"hovered-star\");\n        }\n      });\n    });\n    spanStarClone.addEventListener(\"click\", function (e) {\n      document.querySelectorAll(spanStarSelector).forEach(function (starEl) {\n        starEl.classList.remove(\"clicked-star\");\n      });\n      e.target.classList.add(\"clicked-star\");\n      document.querySelector(inputSelector).setAttribute(\"value\", e.target.dataset.grade);\n    });\n    document.querySelector(starsDivSelector).appendChild(spanStarClone);\n  }\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvdXRpbHMuanMuanMiLCJtYXBwaW5ncyI6Ijs7OztBQUFBQSxPQUFPLENBQUNDLEdBQVIsQ0FBWUMsa0JBQVo7QUFFZSxTQUFTQSxrQkFBVCxDQUNYQyxhQURXLEVBRVhDLGdCQUZXLEVBR1hDLGdCQUhXLEVBSWI7QUFDRUwsRUFBQUEsT0FBTyxDQUFDQyxHQUFSLG1EQUMrQ0UsYUFEL0MsZUFDaUVDLGdCQURqRSxlQUNzRkMsZ0JBRHRGO0FBR0EsTUFBTUMsUUFBUSxHQUFHQyxRQUFRLENBQUNDLGFBQVQsQ0FBdUJILGdCQUF2QixDQUFqQjs7QUFDQSxPQUFLLElBQUlJLENBQUMsR0FBRyxDQUFiLEVBQWdCQSxDQUFDLEdBQUcsQ0FBcEIsRUFBdUJBLENBQUMsRUFBeEIsRUFBNEI7QUFDeEJDLElBQUFBLGFBQWEsR0FBR0osUUFBUSxDQUFDSyxTQUFULENBQW1CLElBQW5CLENBQWhCO0FBQ0FELElBQUFBLGFBQWEsQ0FBQ0UsWUFBZCxDQUEyQixZQUEzQixFQUF5Q0gsQ0FBQyxHQUFHLENBQTdDO0FBQ0FDLElBQUFBLGFBQWEsQ0FBQ0csV0FBZCxHQUE0QixHQUE1QjtBQUNBSCxJQUFBQSxhQUFhLENBQUNJLGdCQUFkLENBQStCLFdBQS9CLEVBQTRDLFVBQUNDLENBQUQsRUFBTztBQUMvQyxVQUFNQyxZQUFZLEdBQUdULFFBQVEsQ0FBQ1UsZ0JBQVQsQ0FBMEJaLGdCQUExQixDQUFyQjtBQUNBVyxNQUFBQSxZQUFZLENBQUNFLE9BQWIsQ0FBcUIsVUFBQ0MsRUFBRCxFQUFRO0FBQ3pCbkIsUUFBQUEsT0FBTyxDQUFDQyxHQUFSLENBQVljLENBQUMsQ0FBQ0ssTUFBRixDQUFTQyxPQUFULENBQWlCQyxLQUE3QixFQUFvQ0gsRUFBRSxDQUFDRSxPQUFILENBQVdDLEtBQS9DOztBQUNBLFlBQUlILEVBQUUsQ0FBQ0UsT0FBSCxDQUFXQyxLQUFYLElBQW9CUCxDQUFDLENBQUNLLE1BQUYsQ0FBU0MsT0FBVCxDQUFpQkMsS0FBekMsRUFBZ0Q7QUFDNUNILFVBQUFBLEVBQUUsQ0FBQ0ksU0FBSCxDQUFhQyxHQUFiLENBQWlCLGNBQWpCO0FBQ0gsU0FGRCxNQUVPO0FBQ0hMLFVBQUFBLEVBQUUsQ0FBQ0ksU0FBSCxDQUFhRSxNQUFiLENBQW9CLGNBQXBCO0FBQ0g7QUFDSixPQVBEO0FBUUgsS0FWRDtBQVdBZixJQUFBQSxhQUFhLENBQUNJLGdCQUFkLENBQStCLE9BQS9CLEVBQXdDLFVBQUNDLENBQUQsRUFBTztBQUMzQ1IsTUFBQUEsUUFBUSxDQUFDVSxnQkFBVCxDQUEwQlosZ0JBQTFCLEVBQTRDYSxPQUE1QyxDQUFvRCxVQUFDUSxNQUFELEVBQVk7QUFDNURBLFFBQUFBLE1BQU0sQ0FBQ0gsU0FBUCxDQUFpQkUsTUFBakIsQ0FBd0IsY0FBeEI7QUFDSCxPQUZEO0FBR0FWLE1BQUFBLENBQUMsQ0FBQ0ssTUFBRixDQUFTRyxTQUFULENBQW1CQyxHQUFuQixDQUF1QixjQUF2QjtBQUNBakIsTUFBQUEsUUFBUSxDQUNIQyxhQURMLENBQ21CTCxhQURuQixFQUVLUyxZQUZMLENBRWtCLE9BRmxCLEVBRTJCRyxDQUFDLENBQUNLLE1BQUYsQ0FBU0MsT0FBVCxDQUFpQkMsS0FGNUM7QUFHSCxLQVJEO0FBU0FmLElBQUFBLFFBQVEsQ0FBQ0MsYUFBVCxDQUF1QkosZ0JBQXZCLEVBQXlDdUIsV0FBekMsQ0FBcURqQixhQUFyRDtBQUNIO0FBQ0oiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvdXRpbHMuanM/YjhmZSJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zb2xlLmxvZyhnZW5lcmF0ZVN0YXJSYXRpbmcpO1xyXG5cclxuZXhwb3J0IGRlZmF1bHQgZnVuY3Rpb24gZ2VuZXJhdGVTdGFyUmF0aW5nKFxyXG4gICAgaW5wdXRTZWxlY3RvcixcclxuICAgIHN0YXJzRGl2U2VsZWN0b3IsXHJcbiAgICBzcGFuU3RhclNlbGVjdG9yXHJcbikge1xyXG4gICAgY29uc29sZS5sb2coXHJcbiAgICAgICAgYGdlbmVyYXRpbmcgc3RhciB3aXRoIGdlbmVyYXRlU3RhclJhdGluZygke2lucHV0U2VsZWN0b3J9LCAke3N0YXJzRGl2U2VsZWN0b3J9LCAke3NwYW5TdGFyU2VsZWN0b3J9KSBmcm9tIHV0aWxzLm1qc2BcclxuICAgICk7XHJcbiAgICBjb25zdCBzcGFuU3RhciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3Ioc3BhblN0YXJTZWxlY3Rvcik7XHJcbiAgICBmb3IgKGxldCBpID0gMDsgaSA8IDU7IGkrKykge1xyXG4gICAgICAgIHNwYW5TdGFyQ2xvbmUgPSBzcGFuU3Rhci5jbG9uZU5vZGUodHJ1ZSk7XHJcbiAgICAgICAgc3BhblN0YXJDbG9uZS5zZXRBdHRyaWJ1dGUoXCJkYXRhLWdyYWRlXCIsIGkgKyAxKTtcclxuICAgICAgICBzcGFuU3RhckNsb25lLnRleHRDb250ZW50ID0gXCLimIVcIjtcclxuICAgICAgICBzcGFuU3RhckNsb25lLmFkZEV2ZW50TGlzdGVuZXIoXCJtb3VzZW92ZXJcIiwgKGUpID0+IHtcclxuICAgICAgICAgICAgY29uc3Qgc3RhckVsZW1lbnRzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChzcGFuU3RhclNlbGVjdG9yKTtcclxuICAgICAgICAgICAgc3RhckVsZW1lbnRzLmZvckVhY2goKGVsKSA9PiB7XHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhlLnRhcmdldC5kYXRhc2V0LmdyYWRlLCBlbC5kYXRhc2V0LmdyYWRlKTtcclxuICAgICAgICAgICAgICAgIGlmIChlbC5kYXRhc2V0LmdyYWRlIDw9IGUudGFyZ2V0LmRhdGFzZXQuZ3JhZGUpIHtcclxuICAgICAgICAgICAgICAgICAgICBlbC5jbGFzc0xpc3QuYWRkKFwiaG92ZXJlZC1zdGFyXCIpO1xyXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICBlbC5jbGFzc0xpc3QucmVtb3ZlKFwiaG92ZXJlZC1zdGFyXCIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9KTtcclxuICAgICAgICBzcGFuU3RhckNsb25lLmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCAoZSkgPT4ge1xyXG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKHNwYW5TdGFyU2VsZWN0b3IpLmZvckVhY2goKHN0YXJFbCkgPT4ge1xyXG4gICAgICAgICAgICAgICAgc3RhckVsLmNsYXNzTGlzdC5yZW1vdmUoXCJjbGlja2VkLXN0YXJcIik7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICBlLnRhcmdldC5jbGFzc0xpc3QuYWRkKFwiY2xpY2tlZC1zdGFyXCIpO1xyXG4gICAgICAgICAgICBkb2N1bWVudFxyXG4gICAgICAgICAgICAgICAgLnF1ZXJ5U2VsZWN0b3IoaW5wdXRTZWxlY3RvcilcclxuICAgICAgICAgICAgICAgIC5zZXRBdHRyaWJ1dGUoXCJ2YWx1ZVwiLCBlLnRhcmdldC5kYXRhc2V0LmdyYWRlKTtcclxuICAgICAgICB9KTtcclxuICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKHN0YXJzRGl2U2VsZWN0b3IpLmFwcGVuZENoaWxkKHNwYW5TdGFyQ2xvbmUpO1xyXG4gICAgfVxyXG59XHJcbiJdLCJuYW1lcyI6WyJjb25zb2xlIiwibG9nIiwiZ2VuZXJhdGVTdGFyUmF0aW5nIiwiaW5wdXRTZWxlY3RvciIsInN0YXJzRGl2U2VsZWN0b3IiLCJzcGFuU3RhclNlbGVjdG9yIiwic3BhblN0YXIiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3IiLCJpIiwic3BhblN0YXJDbG9uZSIsImNsb25lTm9kZSIsInNldEF0dHJpYnV0ZSIsInRleHRDb250ZW50IiwiYWRkRXZlbnRMaXN0ZW5lciIsImUiLCJzdGFyRWxlbWVudHMiLCJxdWVyeVNlbGVjdG9yQWxsIiwiZm9yRWFjaCIsImVsIiwidGFyZ2V0IiwiZGF0YXNldCIsImdyYWRlIiwiY2xhc3NMaXN0IiwiYWRkIiwicmVtb3ZlIiwic3RhckVsIiwiYXBwZW5kQ2hpbGQiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/utils.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
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
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/utils.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;
define([
  'jquery',
  'Vsourz_HotDeals/js/owlCarousel',
], function($){
 'user strict'
  return function (config, element) {
   $(element).owlCarousel(config);
  }
});
/*
 * Morris - Charts
 */

$(function() {


  //Donut Chart
  Morris.Donut({
    element: 'morris-donut',
    data: [{
      label: 'Jam',
      value: 25
    }, {
      label: 'Frosted',
      value: 40
    }, {
      label: 'Custard',
      value: 25
    }, {
      label: 'Sugar',
      value: 10
    }],
    formatter: function(y) {
      return y + "%"
    }
  });


});
/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.box-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
  $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

  // jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder         : 'sort-highlight',
    handle              : '.handle',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });

  // bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5();

  $('.daterange').daterangepicker({
    ranges   : {
      'Today'       : [moment(), moment()],
      'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate  : moment()
  }, function (start, end) {
    window.alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  });

  /* jQueryKnob */
  $('.knob').knob();

  // jvectormap data
  var visitorsData = {
    US: 398, // USA
    SA: 400, // Saudi Arabia
    CA: 1000, // Canada
    DE: 500, // Germany
    FR: 760, // France
    CN: 300, // China
    AU: 700, // Australia
    BR: 600, // Brazil
    IN: 800, // India
    GB: 320, // Great Britain
    RU: 3000 // Russia
  };
  // World map by jvectormap
  $('#world-map').vectorMap({
    map              : 'world_mill_en',
    backgroundColor  : 'transparent',
    regionStyle      : {
      initial: {
        fill            : '#e4e4e4',
        'fill-opacity'  : 1,
        stroke          : 'none',
        'stroke-width'  : 0,
        'stroke-opacity': 1
      }
    },
    series           : {
      regions: [
        {
          values           : visitorsData,
          scale            : ['#92c1dc', '#ebf4f9'],
          normalizeFunction: 'polynomial'
        }
      ]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] != 'undefined')
        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
    }
  });

  // Sparkline charts
  var myvalues = [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021];
  $('#sparkline-1').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#92c1dc',
    fillColor: '#ebf4f9',
    height   : '50',
    width    : '80'
  });
  myvalues = [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921];
  $('#sparkline-2').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#92c1dc',
    fillColor: '#ebf4f9',
    height   : '50',
    width    : '80'
  });
  myvalues = [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21];
  $('#sparkline-3').sparkline(myvalues, {
    type     : 'line',
    lineColor: '#92c1dc',
    fillColor: '#ebf4f9',
    height   : '50',
    width    : '80'
  });

  // The Calender
  $('#calendar').datepicker();

  // SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').slimScroll({
    height: '250px'
  });
  /* Morris.js Charts */
  // Sales chart
  var area = new Morris.Bar({
    element   : 'revenue-chart',
    resize    : true,
    data      : script,
    xkey      : 'y',
    ykeys     : ['Sale'],
    labels    : ['Sales (<i class="fa fa-inr"></i>)'],
    lineColors: ['#a0d0e0', '#3c8dbc'],
    hideHover : 'auto',
    formatX: function(x) { // <--- x.getMonth() returns valid index
      x = x.label;
      var month = months[new Date(x).getMonth()];
      return month+' '+ new Date(x).getFullYear();
    },
    dateFormat: function(x) {
      var month = months[new Date(x).getMonth()];
      return month+' '+ new Date(x).getFullYear();
    }
  });
  // Purchase chart
  /*var purchase_area = new Morris.Bar({
    element   : 'purchase-chart',
    resize    : true,
    data      : purchase_script,
    xkey      : 'y',
    ykeys     : ['Purchase'],
    labels    : ['Purchase (<i class="fa fa-inr"></i>)'],
    lineColors: ['#a0d0e0', '#3c8dbc'],
    hideHover : 'auto',
    formatX: function(x) { // <--- x.getMonth() returns valid index
      x = x.label;
      var month = months[new Date(x).getMonth()];
      return month+' '+ new Date(x).getFullYear();
    },
    dateFormat: function(x) {
      var month = months[new Date(x).getMonth()];
      return month+' '+ new Date(x).getFullYear();
    }
  });*/
  var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  var line = new Morris.Line({
    element          : 'line-chart',
    resize           : true,
    data             : script2,
    xkey             : 'y',
    ykeys            : ['Received'],
    labels           : ['Received (<i class="fa fa-inr"></i>)'],
    lineColors       : ['#2c20e4'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10,
    xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
      var month = months[x.getMonth()];
      return month+' '+ x.getFullYear();
    },
    dateFormat: function(x) {
      var month = months[new Date(x).getMonth()];
      return month+' '+ new Date(x).getFullYear();
    },
    ymin: 0
  });
  //For Purchase payment
 /* var purchase_line = new Morris.Line({
    element          : 'purchase-payment',
    resize           : true,
    data             : purchase_script2,
    xkey             : 'y',
    ykeys            : ['Payment'],
    labels           : ['Payment (<i class="fa fa-inr"></i>)'],
    lineColors       : ['#2c20e4'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10,
    xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
      var month = months[x.getMonth()];
      return month+' '+ x.getFullYear();
    },
    dateFormat: function(x) {
      var month = months[new Date(x).getMonth()];
      return month+' '+ new Date(x).getFullYear();
    },
    ymin: 0
  });*/

  // Donut Chart
  /*var donut = new Morris.Donut({
    element  : 'sales-chart',
    resize   : true,
    colors   : ['#3c8dbc', '#f56954', '#00a65a'],
    data     : [
      { label: 'Pending Invoices', value: pending },
      { label: 'Completed Invoices', value: completed_invoice },
      { label: 'Partly Completed', value: part_completed_invoice }
    ],
    hideHover: 'auto'
  });*/

  // Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    purchase_area.redraw();
    //donut.redraw();
    line.redraw();
    purchase_line.redraw();
  });

  /* The todo list plugin */
  $('.todo-list').todoList({
    onCheck  : function () {
      window.console.log($(this), 'The element has been checked');
    },
    onUnCheck: function () {
      window.console.log($(this), 'The element has been unchecked');
    }
  });

});

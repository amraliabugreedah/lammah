'use strict';
/* jshint maxcomplexity: 12 */

/* jquery-tablesorter by Severin Puschkarski
 * https://github.com/zevero/jquery-tablesorter
 * 
 * <table class="jquery-tablesorter">
 *   <thead>
 *     <tr>
 *       <th data-sort="text/num/class/...">Title</th>
 *       ...
 */
$(function() { //table sorter
  
  function getCell(row, index) { return $(row).children('td').eq(index);}
  
  function comparer(index, type) {
    return function(a, b) {
      var cellA = getCell(a, index), valA = cellA.text(),
          cellB = getCell(b, index), valB = cellB.text();
      switch (type){
        case 'text': return valA.localeCompare(valB);
        case 'money': return parseInt(valA.replace('.', '').replace(',', ''),10)-parseInt(valB.replace('.', '').replace(',', ''),10);
        case 'num': return parseFloat(valA) - parseFloat(valB);
        case 'num_no_null': return (parseInt(valA,10)||9e8) - (parseInt(valB,10) || 9e8);
        case 'class': return 1000*(cellA.attr('class')||'zzzzz').localeCompare(cellB.attr('class')||'zzzzz') + valA.localeCompare(valB);
        case 'date_de':
          a=valA.split('.');
          b=valB.split('.');
          return a[2]*400+a[1] * 32 + a[0] * 1 - b[2] * 400 - b[1]*32 - b[0] * 1; 
        default: //throw new Error('jquery-tablesorter error: Type ' + type + ' not defined!');   //instead of throwing an error
          return $.isNumeric(valA) && $.isNumeric(valB) ? parseFloat(valA) - parseFloat(valB) : valA.localeCompare(valB); //we just guess
      }
    };
  }
  
  
  $('body').on('click', 'table.jquery-tablesorter th[data-sort]', function() {
    var $th = $(this);
    var orig = {                                                          //original state
      index: $th.index(),
      asc : !!$th.data('asc'),
      sort: $th.data('sort')
    };
       
    var $table = $th.closest('table');
    var table = $table[0];
    var state = table.jquery_tablesorter_state || orig;                   //get old table state or save as original state
    if (orig.index !== state.index) state = orig;                         //if index changed reset 
    state.asc = !state.asc;                                               //change asc
    table.jquery_tablesorter_state = state;                               //save state for next time

    $table.find('>tbody').each(function() {                               //works with seperate tbodys!
      var $tbody = $(this);
      var trs = $tbody.find('>tr:not(\'.staticRow\')');                                       //get rows
      var trStatic = $tbody.find('tr.staticRow');                                       //get rows
      var rows = trs.toArray().sort(comparer(state.index, state.sort));   //sort them
      if (!state.asc)  rows = rows.reverse();                             //reverse them if needed
      for (var i = 0; i < rows.length; i+=1) $tbody.append(rows[i]);      //put them back in the right order
        $tbody.append(trStatic);
    });
    
  });
});

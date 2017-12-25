# jquery-tablesorter

oh no ... my table should be sortable ... jquery-tablesorter to the rescue!

## Simple!

0. `bower install jquery-tablesorter --save`
1. Include jquery-tablesorter.js
2. add class="jquery-tablesorter" to your table
3. add data-sort="text/num/class/..."

## Example:

    <table class="jquery-tablesorter">
      <thead>
        <tr>
          <th data-sort="text">Product</th> 
          <th data-sort="num">Quantity</th> //forces a number 
          <th data-sort="date_de">Date</th> //Sorts a gemran Date dd.mm.YYYY
          <th data-sort="class">Payed</th>  //Sorts by classname
        </tr>
      </thead>
      <tbody>
        ...
      </tbody
    </table>
    
 

</div><!--=========jQuery and jQuery Tools		--><script src="js/jquery-1.9.1.js"></script><script src="js/jquery-ui-1.10.3.custom.min.js"></script><script type="text/javascript">  $(document).ready(function () {       $('#showHideFilter').click(function(){          $("#filter").slideToggle();      });  });	$( '#selectDate' ).datepicker({      changeYear: false,      showButtonPanel: false,      numberOfMonths: 2,      dateFormat: 'dd-mm-yy',  }); <?php      if ( $jsStartDate || $jsEndDate ) {            $js_date_start = date('d-m-Y', $jsStartDate);            $js_date_end = date('d-m-Y', $jsEndDate);            $diff = $jsStartDate - $jsEndDate;            if ($diff < 0) {                $diff -= ($diff * 2);            }            $diff = floor($diff / (3600 * 24));?>var SelectedDates = {};    SelectedDates['start'+new Date('<? echo $js_date_start; ?>')] = new Date('$<? echo $js_date_start; ?>');    SelectedDates['end'+new Date('<? echo $js_date_end; ?>')] = new Date('<? echo $js_date_end; ?>');$(function() {	 $( '#filterStartDate' ).datepicker({      changeYear: false,      showButtonPanel: false,      maxDate: '0',      minDate: '-<? echo $diff; ?>D',      numberOfMonths: 2,      dateFormat: 'dd-mm-yy',      beforeShowDay: function(date) {            var Highlight = SelectedDates['end'+date];            if (Highlight) {                return [true, "ui-state-active", ''];            }            else {                return [true, '', ''];            }        }    });                         $( '#filterEndDate' ).datepicker({      changeYear: false,      showButtonPanel: true,      minDate: '-<? echo $diff; ?>D',      maxDate: '0',      numberOfMonths: 2,      dateFormat: 'dd-mm-yy',      beforeShowDay: function(date) {            var Highlight = SelectedDates['start'+date];            if (Highlight) {                return [true, "ui-state-highlight ui-state-active", ''];            }            else {                return [true, '', ''];            }        }       });})<?php } //End js for date filters ?></script></body></html>
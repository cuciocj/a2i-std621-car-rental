$( function() {
    var dFormat = "yy-mm-dd",
        from = $( "#from" )
            .datepicker({
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1
            })
            .on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
            }),
        to = $( "#to" ).datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
        })
        .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
        });

    function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dFormat, element.value );
        } catch( error ) {
            date = null;
        }

        return date;
    }
} );
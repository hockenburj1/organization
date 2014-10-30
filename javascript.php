<head>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

<script>
    function get_posts() {
        $.getJSON( "http://www.usa.gov/api/USAGovAPI/contacts.json/contacts")
            .done(function( data ) {
                
                for (i = 0; i < data.Contact.length; i++) {
                    row = data.Contact[i];
                    phone = row.Phone;
                    
                    if(! phone){
                        phone = "";
                    };
                    
                    document.write(
                       '<a href="' +  row.Web_Url[0].Url + '" class="title">' + row.Name + '</a> - ' + phone + '<br/>'    
                    );
                }
            });
    }        

</script>
</head>

<div id='result'>
    <script>get_posts();</script>    
</div>



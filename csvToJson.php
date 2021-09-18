<!DOCTYPE html>
<html>
  <head>
    <title>CSV to JSON</title>
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Source+Code+Pro" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.6/styles/monokai.min.css">
  </head>

  <body>

  <div id="container">
    <section id="content">
      <h2>CSV to JSON</h2>
      <hr>

      <h2>Input:</h2>
        <textarea id="input" style="height: 300px; width: 94%;">id,name,description,files,previewImage,template,color mode,background,tv,accessory,effect,amount
1,#1,The NoMoreTV project  is a set of 9999 unique digital collectibles minted on the Ethereum blockchain. Visit nomore.tv for more details.,pu3gnb4k.svg,pu3gnb4k.png,Dinner time,Trichromatic,Pink Rapsberry,Black,Orange,null,1
2,#2,The NoMoreTV project  is a set of 9999 unique digital collectibles minted on the Ethereum blockchain. Visit nomore.tv for more details.,7yhzte53.svg,7yhzte53.png,XTC,Trichromatic,Yellow Tulip,Purple,Orange,null,2</textarea>
      <input id="run" type="button" value="Run" style="display: block; padding: 6px 24px; margin-bottom: 16px;" />
      <hr />

      <h2>Result:</h2>
      <textarea id="result" style="height: 1400px; width: 94%;"></textarea>
      <input id="run-result" type="button" value="Run" style="display: block; padding: 6px 24px; margin-bottom: 16px;" />
      <hr />

      <h2>Edited JSON:</h2>
      <textarea id="edited-json" style="height: 1400px; width: 94%;"></textarea>

    </section>
  </div>

  <script src="http://code.jquery.com/jquery-3.3.1.slim.js" integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA=" crossorigin="anonymous"></script>
  <script src="/wp-content/NFT/jquery-csv-main/src/jquery.csv.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.6/highlight.min.js"></script>
  <script>
    // enable syntax highlighting
    hljs.initHighlightingOnLoad();

    $(document).ready(() => {
      parse();
    });

    $('#run').bind('click', function () {
      parse();
    });

    function parse() {
      const input = $('#input').val();
      const data = $.csv.toObjects(input);
      $('#result').empty();
      $('#result').html(JSON.stringify(data, null, 2));
    }


    ( function($) {
      $("#run-result").click(function(){
  
        var json_data = JSON.parse($("#result").val());
        console.log(json_data);
        
        //const attr = ["id", "files"];
        const attr = ["template", "color mode", "background", "tv", "accessory", "effect"];
        for ( var j = 0; j < json_data.length; j++ ) {
         
          var element = {};
          for ( var i = 0; i < attr.length; i++ ) {

            if ( json_data[j][attr[i]].indexOf("null") === -1 ) {
              console.log( json_data[j][attr[i]] );
              element[attr[i]] = json_data[j][attr[i]];
              //element[attr[i]] = json_data[j][attr[i]];

              delete json_data[j][attr[i]];
            }

          }

            json_data[j].metadata = JSON.stringify(element);
                    
        }
   
        $('#edited-json').html( JSON.stringify(json_data) );
        

      });

    }(jQuery) );


    </script>
  </body>
</html>

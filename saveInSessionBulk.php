
<!doctype html>
<html>
<head>
    <title>Save in Session - Bulk</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>

<h2>Bulk Upload - CARGO</h2>
<form id="file-form" method='post' action='' enctype='multipart/form-data'>    
    <label for="file" style="font-size: 18px; letter-spacing: 0.5px;">Select Your Files:</label>
    <input type="file" name="file[]" id="file" multiple required style="font-size: 18px; letter-spacing: 0.5px;">

    <label for="sessionId" style="font-size: 18px; letter-spacing: 0.5px;">Your Existing Session Id:</label>
    <input type="text" name="session-Id" value='61423c04893e0d002029310d' id="session-Id" style="padding: 8px 16px; font-size: 18px; letter-spacing: 1.6px; width: 300px;">
    
    <input type="button" name="submit" value='Send' id="button-input" disabled style="padding: 8px 16px; font-size: 18px; letter-spacing: 0.5px;">
</form>

<hr>

<h2>Info:</h2>
<div id="info" style="font-size: 18px; letter-spacing: 0.5px; height: 300px;
    overflow-y: auto;"></div>

<hr>

<h2>Input Your JSON:</h2>
<textarea id="json-input" style="height: 300px; width: 94%;"></textarea>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://assets.cargo.build/cargo.7.1.2.js"></script>
<script>
(function($) {

var my_network = prompt("production or development?:", "development");

// Create a new instance of the Cargo class
const cargo = new window.cargoJs.Cargo({ network: my_network });

async function enable() {
    console.log("enable() function called");
    // Check if user has a web3 provider available
    if (cargo.hasProvider) {
        console.log("Provider Found");
        // Enable Cargo
        const enabled = await cargo.enable();
        
        if(enabled) {
            
            /*-- Authenticate existing account --*/
            cargo.api.authenticate().then((response) => {
                if(response.status === 200){
                    $("#info").append("<p>User is authenticated</p>");

                    //--- On Submit ---
                    $("#button-input").click(function(){
                
                        /* Save NFT Data in Session */
                        const sessionId = $('#session-Id').val();           

                        var my_files = $("#file")[0].files;
                        //console.log(my_files[0].name.replace(/\.[^/.]+$/, ""));
                        
                        var nfts = JSON.parse($("#json-input").val());
                        //console.log(nfts);
                        console.log(nfts[0].previewImage);
                        console.log(nfts[0].file);

                        $("#info").html("<p>Records added: " + nfts.length + "<br>Files chosen: " + my_files.length + "</p>");
                        var previewImageCount = 0, filesCount = 0;
                        for ( var i = 0; i < my_files.length; i++ ) {
                            console.log( my_files[i].name );

                            for ( var j = 0; j < nfts.length; j++ ) {
                                //console.log( nfts[j].files );
                                //console.log( nfts[j].previewImage );

                                if ( nfts[j].previewImage == my_files[i].name ) {
                                    nfts[j].previewImage = my_files[i];
                                    previewImageCount++;
                                }
                                if ( nfts[j].files == my_files[i].name ) {
                                    nfts[j].files = [ my_files[i] ];
                                    console.log( "files matched" );
                                    filesCount++;
                                }
                                
                            }

                        }

                        console.log(nfts);
                        console.log(nfts[0].previewImage);
                        //console.log(nfts[0].file);

                        $("#info").append("<p>'previewImage' matched: " + previewImageCount + "<br>'files'  matched: " + filesCount + "</p>");
                        if ( nfts.length == previewImageCount && nfts.length == filesCount ) {
                            $("#info").append("<p>Adding " + nfts.length + " NFTs, please wait. . .");
                        }else {
                            $("#info").append("<p>Records - Files Mismatch, the Import will probably Fail");
                        }

                        cargo.api.saveNft(sessionId, nfts).then(() => {
                            $("#info").append("<p>NFT Data Saved in Session</p>");
                        });

                        //$("#button-input").prop("disabled", true);  

                    });


                }
            });

                                        
        }
    }
}

enable();


// Event stating that Cargo JS is enabled
cargo.on('enabled', () => {
    //console.log("Cargo JS is enabled");
    $("info").append("<p>Cargo JS is enabled</p>");
});

// Event stating that enabling was rejected. Either an error was thrown, or the user rejected
cargo.on('enable-required', () => {
    //console.log("An error was thrown, or the user rejected");
    $("info").append("<p>An error was thrown, or the user rejected</p>");
});

// MetaMask supported event. Emitted when accounts change. First argument of callback function is an array of accounts.
cargo.on('accounts-changed', (accounts/*: Array<Account>*/) => {
    //console.log("Accounts changed");
    $("info").append("<p>Accounts changed</p>");
});

// Fired if cargo.enable is called without a web3 provider available.
cargo.on('provider-required', () => {
    //console.log("cargo.enable is called without a web3 provider available");
    $("info").append("<p>cargo.enable is called without a web3 provider available</p>");
});


//--- Show File Info on Input Change ---
const file_input = $("#file");
file_input.on('change', function() {

    var txt = "";
    if (file_input.prop('files')!= 0) {
        if (file_input.prop('files').length == 0) {
            txt = "Select one or more files.";
        } 
        else {
            for (var i = 0; i < file_input.prop('files').length; i++) {
                txt += '<li id="on-change-info"><strong>' + (i+1) + '. file</strong><br>';
                var file = file_input.prop('files')[i];
                if ('name' in file) {
                    txt += 'name: ' + file.name + '<br>';
                }
                if ('size' in file) {
                    txt += 'size: ' + Math.round(file.size/100)/10 + ' Kb</li>';
                }
            }
            $("#button-input").prop('disabled', false);
            $('body').addClass('files-chosen');
        }
    } 
    else {
        if (file_input.val() == "") {
            txt += "Select one or more files.";
        } else {
            txt += "File upload is not supported by your browser!";
            txt += "<br>The path of the selected file: " + x.val(); 
        }
    }
    $("#info").html(txt);

});


}(jQuery) );

</script>


</body>
</html>
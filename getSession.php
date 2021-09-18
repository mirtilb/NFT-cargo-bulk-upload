<!doctype html>
<html>
<head>
    <title>Get Session</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />	
</head>

<body>


<h2>Input Your Existing Session Id (sessionId):</h2>
<input type="text" name="sessionId" value='61423c04893e0d002029310d' id="session-Id" style="padding: 8px 16px; font-size: 18px; letter-spacing: 1.6px; width: 320px;">
<input type="button" name="submit" value='Get Session' id="button-input" style="padding: 8px 24px; font-size: 18px; letter-spacing: 0.5px;">

<div id="info"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://assets.cargo.build/cargo.7.1.2.js"></script>
<script>

( function($) {

// Create a new instance of the Cargo class
const cargo = new window.cargoJs.Cargo({ network: 'development' });

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
                    console.log("User is authenticated");
                    
                    //--- On Submit ---
                    $("#button-input").click(function(){
                        const sessionId = $('#session-Id').val();                     

                        /* Get an Existing Minting Session */
                        cargo.api.getMintingSession(sessionId).then(data => {
                            console.log(data);
                            var info;
                            info += "<h2>Total: " + data["nfts"].length + "</h2>";
                            for (let key of data["nfts"]) {
                                info += "<div>";
                                info += "<p>ID: " + key.uuid + "</p>";
                                info += "<p>Amount: " + key.amount + "</p>";
                                info += "<p>CreatedAt: " + key.createdAt + "</p>";
                                info += "<p>Description: " + key.description + "</p>";
                                info += "<p>Name: " + key.name + "</p>";
                                info += "<p>Session: " + key.session + "</p>";
                                info += "<p>Size: " + key.size + "</p>";
                                info += "<p>Metadata: " + key.metadata + "</p>";
                                for (let item of key.fileMap.previewImage) {
                                    info += "<p>" + item.originalFileName + "</p>";
                                    info += '<p><img style="width: 180px;" src="' + item.url + '"/></p>';
                                }
                                info += '</div><br><hr style="margin: 0 0 32px;">';

                            }
                            //console.log(info);
                            document.getElementById("info").innerHTML = info;

                        });


                    });


                }
            });

                                        
        }
    }
}

enable();


// Event stating that Cargo JS is enabled
cargo.on('enabled', () => {
    console.log("Cargo JS is enabled");
});

// Event stating that enabling was rejected. Either an error was thrown, or the user rejected
cargo.on('enable-required', () => {
    console.log("An error was thrown, or the user rejected");
});

// MetaMask supported event. Emitted when accounts change. First argument of callback function is an array of accounts.
cargo.on('accounts-changed', (accounts/*: Array<Account>*/) => {
    console.log("Accounts changed");
});

// Fired if cargo.enable is called without a web3 provider available.
cargo.on('provider-required', () => {
    console.log("cargo.enable is called without a web3 provider available");
});


}(jQuery) );

</script>


</body>
</html>
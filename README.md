# NFT-cargo-bulk-upload

PROJECT: NO MORE TV (NMTV)<br>
https://opensea.io/collection/nomoretv<br>
https://opensea.io/collection/nomoretv-alpha<br><br>

CARGO BUILD<br>
Smart contract: ERC-721 + EIP 2309 (recursive patch)<br>
https://cargo.build/<br><br>

DEV<br>
georgerockjohn | https://www.fiverr.com/georgerockjohn<br>


GOAL<br>
A solution to import everything at once

1/ getSession.php: 
- connect to your ETH address with Metamask
- add session id :on frontend, choose an existing session and take the id at the url ending (&sessionId=xxxxxxx)

2/ csvToJson.php:
- import the csv formated like sample.csv
- run the 1st converter for metadata
- run the 2nd converter for custom metadat and to uglify the code

3/ saveInSessionBulk.php
- select "Developement" or "production" environment 
- you should see a default message saying you're logged if your Metamask connexion is ok
- choose all images files you need from the same folder (previewImage + locked files) to display file list. check the ending to be sure you selected all files
- paste again the session ID
- paste the converted json
- click send

EXAMPLE MESSAGE:
- records added: 1000
- Files choosen : 2000 (should be twice the records number if you had for each collectible a previewImage + a locked file)
- previewImage: 1000
- files: 1000
- Adding 1000 NFTs, please wait...
- WHEN IT'S DONE: "NFT DAta Saved in Session"

NOTES
- group all collectibles in the same session or you'll pay as many transaction fees as existing sessions.
- if there are missing image files, you'll see a message explain ing the bulk upload could fail.
- If something goes wrong while uploading collectibles, there is no warning message to explain why. 
- Better to upload at night in the US because CARGO server isn't stable, or maybe the team is working on changes without notice. At first, it stopped 5 times. While - at the right moment, no issue to upload 10k at once.
- No upload status (uploading collectible 1 of 1000) but you can check the result on CARGO frontend if you upload lots of collectibles at once. 
- It took me 6 hours to upload 10k collectibles with 2Go images.
- When it's done, you'll have to click on SAVE AND CONTINUE button on frontent (it may take 2 to 3 hours for 10k collectibles) then you will pay the transaction to mint all NFTs at once

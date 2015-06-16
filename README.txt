 __  __              
|  \/  |___ _ _  ___ 
| |\/| / _ \ ' \/ _ \
|_|  |_\___/_||_\___/
                     
                                  
 . . ,---.         ,   .          |    
-+-+-|__. ,---..  ,|   |,---.,---.|---.
-+-+-|    |   | >< `---'|---',---||   |
 ` ` `    `---''  `  |  `---'`---^`   '
                     `                 

Authors: 
	Charlie Hield
	Kevin Truckenmiller

Theme Installation Instructions:

	Make sure your base URL is set to https if you are using https.

	Activate/Download Plugins:
	- Advanced Custom Fields
	- WP Bitly
	- Wordpress Importer
	- ACF - Options - Page
	- Video Thumbnails


	--- ENABLE ALL PLUGINS LISTED ABOVE before continuing ---



	Configuration and Settings within wordpress for a complete new build:

	1. Import Custom Fields using the wordpress import tool (foxyeah_customfields.xml file that should be in the theme directory)
	
	2. Go to Options -> Image -> add Image "wp-content/themes/foxyeah/images/foxyeah-generic.png"
		- SiteBitly - Generate this bitly by logging into mozillas bitly account and generating a new bitly based on the url
		- API keys should all be made active on save - make sure and save
		- Enter default data in for social required fields
		- enter default data in for email fields (as of now we don't have copy for it)

	3. Video Thumbnail Enable
		- In wordpress admin, go to Settings -> Video Thumbnails -> Post Types - Then make sure 'video' is checked
		- Right below that, there is a Custom Field (optional) field. Just click the 'automatically detect button'
		- Click on the 'Automatically Set Featured Image' checkbox
		- If you're having problems with the video image showing up, just go to the specific Video Post type and click 'reset video thumbnail'

	4. Enable larger images
		- In wordpress admin go to Settings -> Media  and set the 'Medium Size' and the 'Large Size' accordingly
			Medium Size: max-width '550' / max-height '2400'
			Large Size: max-width '1100' / max-height '3800'.so

	5. Create a couple pages with templates attached to them
		Create a page named 'send email', and set that page template to 'send email'
		Create a page named 'unsubscribe', and set that page template to 'email unsubscribe'

	6. Create a couple pages that don't need templates attached ot them
		Create a page name 'privacy' - this is where the privacy notice content will go


	Pushing to server: 
		If you are pushing to a wp-content/themes directory, make sure the following files are ignored on the push. 

		.git/
		tools/
		config.codekit
		.sass-cache/
		.gitignore
		.DS_Store 


		If you are having problems with the code being refreshed or not compiling, make sure codekit is busting the CDN with the versioning hook within the hooks section.

		If you need to recompile the handlebars templates (in case you have changed anything in the src/handlebars folder), you can do that by just running the compile command after you've edited the handlebars file. 

		1. In terminal, make sure you have handlebars installed globally 'npm install handlebars -g' 
		2. navigate to the /tools/handlebars-compile directory and type './handlebars-compile' (this will run the bash file)
	 	3. This will output a templates file that will compile within codekit, so make sure codekit is open and ready to recompile all the javascript.

		If you need to install NPM (Node)
		https://docs.npmjs.com/getting-started/installing-node
		Then, install handlebars globally 
		'npm install handlebars -g'



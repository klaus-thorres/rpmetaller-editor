# rpmetaller-editor
A web-based tool to store, manage and export information about concerts and festivals
including bands. venues and cities.

This software was created to support the Ruhrpottmetaller project
(https://www.facebook.com/Ruhrpottmetaller/).
## License
This work is provided under the terms of the MIT licence. Please take a look at the LICENSE file for the full text.
## Features
* Save and edit data related to events.
* Edit the names of bands, cities, venues.
* Export concerts and festivals in human-readable form.
* Mark bands whose concerts should not be exported.

## Technology
These software versions are known to work:
* PHP 8.0
* Apache 2.5
* MariaDB 10.4 or MySQL 8.0

## Installation
To install the software the following steps are necessary:
* Install and configure PHP, the Webserver and MariaDB or MySQL.
* Download the project by cloning it or fetching one of these files:
  * zip: https://github.com/klaus-thorres/rpmetaller-editor/zipball/main
  * tar.gz: https://github.com/klaus-thorres/rpmetaller-editor/tarball/main
* Make the content of the “deploy” folder accessible for the web server.
* Import the database from the file “databases_rpm.sql” in the “database” folder
  into your database management software.
* Create the “db_connect.inc.php” file in the “deploy/include” folder, which contains the
  login data for the database management software and the name of the database you
  selected previously. A sample file is located in that folder.

## Using
This section describes, how to use the software. Every link at the top has its own
subsection.

On some sites it is possible to narrow down the displayed items by month, first letter
or other categories. In this case, a second row with form elements is displayed.

The concert editor as well as the concert export function need JavaScript activated in
your browser. So do not forget to activate it for the application.
### Concerts
This is the main site of the *rpmetaller-editor*.
You can use the buttons at the top of the page to browse through all concerts saved in
the database. You can also jump back to the current month by clicking the button with
the small circle.

Clicking at the plus image at the left of a concert opens a human-readable export.
Export settings can be made on the Preferences site.

Several commands can be applied to a concert using the drop down menu at the right:
* `Add` opens the concert editor. The date of the concert on which you start the add
  command, is the preset for the date of the new concert in the editor.
* `Edit` opens the concert editor.
* `Published` marks the concert as published.
* `Del` deletes the concert from the database. It is therefore irrevocably deleted from
  the system.
* `Sold Out` marks the concert as sold out. As a result, the corresponding concert exports
  are generated containing the information that the concert is sold out. This affects this
  site and the Export site.

A concert can be displayed in different colors:
* black: The concert is already marked as published.
* blue: The concert has not yet been marked as published. 
* red: The concert has not yet been marked as published and will be within the next two
  weeks. If it is a festival (a concert with more than one day), it will be within the
  next 60 days.

Bands written in light brown are marked as not visible.
#### Concert editor
This is the tool for adding or editing concerts. The only necessary input fields for saving
the concert are the date and the url.
##### General concert data
In the first part of the editor general information of the concert are entered.

If a city is not yet in the database, it is possible to add it by selecting the option
“New city” from the bottom of the city drop down menu.  If a city menu option is already
selected, a new venue can be added to the database. In this case you have to select the
option "New venue" in the second dropdown menu. (Tip: Press "n" a few times until the
option shows up.)

The new venue input field is automatically shown if you insert a new city.
Also, by creating new venues you can enter a default url. This will be put in the URL
field when you choose a venue and the URL is not yet set to spare you a few clicks.
##### Concert lineup
Each row represents a band in the lineup.

If you choose a character in the first dropdown menu, bands with those initial letter are loaded in the second one.
The percentage symbol stands for special characters. Also, you can add a new band to the
database and the lineup by
choosing the last option of the second menu. If you do not select a character in the first
dropdown menu, you can choose between also adding a new band to the database and the lineup
or an entry which is labeled “TBA“ (To be announced) or “Support”.

The input field named “Extra information” serves for additional information about this show
by this band. This may be the information about an acoustic show or a special set.

Clicking one of the four buttons at the end of the row has the following effect:
* Plus sign: Adds a band under the current row
* Minus sign: Deletes the band from the lineup
* Arrow signs: Moves the band in the lineup up or down

As you can see, most of your work can be done on this two pages. 
### Bands
On this site you can edit the names of the bands in the database.
Also, you can mark them as not visible. In this case, the band is written in light brown
letters in the concert overview. Also concerts with the corresponding band are not be
included in the export on the Export site.

Filtering the bands by the first character of its name using the dropdown menu at the top.
### Cities
On this site you can edit the names of the cities in the database. 

Filtering by the first character is also possible on this page.
### Venues
On this site you can edit venue names in the database.A Default URL for each venue can also
be added to the database. If you select the venue in the concert editor and the URL field is
still empty, this URL will be filled in there.

The system can contain multiple venues with the same name as long as they are located in 
different cities. 

In this scope filtering by the city is possible.
### Export
A human-readable list of the concerts of the currently selected month is created on the
export page. The header and the footer can be configured on the Preferences site.
You can scroll through the months at the top of the page. You can also jump to the current
month by clicking the button with the small circle.
### Preferences
Using this site a few preferences can be made.

The first drop-down menu is to select the export language of concert exports. Currently
English and German is supported.

The two text areas allow to change the header and the footer of the export generated on the
Export site.
## How to contribute
To make a contribution, please clone the project, make your changes and then open a push
request or send an e-mail created with `git format-patch` to the contact address below.
Development takes place in the `development` branch. 

If you want to support the development, you can send money via PayPal to
https://www.paypal.me/klausthorres or BTC to 13TTodytvT7GebEAfHusb3ug87Sos3W3nk.
## Contact
If you have any question, just drop a message at thorres [at] brothersofgrey [dot] net.

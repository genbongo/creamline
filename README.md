# creamline
this repo is intended for Creamline Project ONLY

THINGS TO DO WHEN YOU WANT TO TEST THE CODE LOCALLY:

Get the file:
- git clone https://github.com/genbongo/creamline.git

After cloning, make sure to run the command first:
- npm install
- npm run dev

After installing the necessary packages, make sure to create a database in your local and name it "creamline"
After creating the database in your local, go to your file, make sure to run the command for creating the tables:
- php artisan migrate

Then, insert our auto generated users:
- php artisan db:seed

Then run the code locally:
- php artisan serve

Go to your browser and type the following link:
http://127.0.0.1:8000

Good luck! :)

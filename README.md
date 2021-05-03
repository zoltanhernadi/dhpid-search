# DHPID-Search

## Description
This repository contains the source code for the Drug and Health Product Inspections Database (DHPID), Assisted Human Reproduction search site revamp. This project follows the guidelines from GCWeb and Web Experience Toolkit for making government online entities. Visit https://wet-boew.github.io/wet-boew/index-en.html for more details. This project was coded using the framework Laravel which is PHP based.

## How To
Cloning and running this program is rather simple.
1. Follow the readme within repository dhpid-admin and create a second database user with only SELECT privilege for use with this public-facing search site.
2. Go to your command line and clone the repository using `git clone [repository_url]`
3. Enter dhpid-search in your command line: `cd dhpid-search`
4. Stop git from tracking file permissions by running `git config core.fileMode false`
5. Run `composer install` in the command line
6. Run `cp -a .env.example .env` and update the new .env file with your database information
7. While still in the directory run `php artisan key:generate` and `php artisan config:cache`
8. Configure your HTTP server (Apache/Nginx, etc) to point to the public directory. If you are doing local development, while in the dhpid-admin directory, run `php artisan serve --host=0.0.0.0` and you will be given a website address to go to which is being hosted by php's webserver. For more information on setting up a HTTPD server with Laravel see the [Laravel Documentation for Deployment](https://laravel.com/docs/8.x/deployment)


## Views

### Search View
This view displays the search filters form with the intention of finding an inspection, this view expects nothing unless invalid inspection dates are chosen when submit is clicked or the site is currently offline, if there is an error it expects an array of errors to be passed, as well as all the requests previously made in the form. The error array should be named 'er'. 
Example Usage:
```php
 return back()->withInput($request->all())->with('er', array('endDate'=>'Inspection end date - Please enter inspection end date greater than or equal to inspection start date'));
```

### Result View
This view displays a list of inspections based on the filters you pass to it in the search view. If no filters are delivered it displays all inspections. The result view expects a laravel collection of inspection objects named 'inspections' and all the search filters (query string) in an array called 'params' from the controller.
Example Usage:
```php
return view('result', ['inspections' => $inspections->get(), 'params' => $request->all()]);
```

### Establishment View
This view displays information regarding a single establishment as well as a list of past inspections. The establishment view expects a single establishment model named 'establishment' from the controller, the controller accepts an establishment_id in the query string in order to find said establishment.
Example Usage:
```php
$establishment=Establishment::where('id',$id)->first();
return view('establishment', ['establishment'=>$establishment]);
```

### Deficiencies View
This view displays all the information from an Initial Inspections Deficiency report. It expects a single inspection model named 'inspection' from the controller, the controller accepts an inspection_id in the query string in order to find said Initial Inspections deficiency report.
Example Usage:
```php
$inspection=Inspection::where('id',$id)->first();
return view('deficiencies', ['inspection'=>$inspection]);
```

### ReportCard view
This view display information regarding an establishments Inspection Report Card. The reportcard view expects a single reportcard model named 'reportcard' from the controller, the controller accepts a reportcard_id in the query string in order to find said Inspection Report Card.
Example Usage:
```php
$reportcard=ReportCard::where('id',$id)->first();
return view('reportcard', ['reportcard'=>$reportcard]);
```
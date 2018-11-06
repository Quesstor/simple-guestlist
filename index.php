<?php include("api/engine.php"); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $GLOBALS["settings"]["title"]; ?></title>
</head>
<body style="background: <?php echo $GLOBALS["settings"]["backgroundcolor"]; ?>; color: white;">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script> 
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <center ng-app="myApp" ng-controller="myCtrl">
        <div style="width: 250px;">
            <br><br>
            <img src="<?php echo $GLOBALS["settings"]["logo"]; ?>">
            <br><br><br>
            <div ng-show="settings.full" class="alert alert-danger">
                Die Liste ist leider schon voll!
            </div>
            <div ng-show="!settings.full">
                <div ng-show="settings.loginrequired && !loginOK">
                    <label>Login</label>
                    <input type="text" ng-model="account.name" placeholder="Name" class="form-control">
                    <input type="password" ng-model="account.pw" placeholder="Password" class="form-control">
                    <br>
                    <div class="btn btn-primary pull-right" ng-click="login()">Login</div>
                </div>
                <div class="ng-hide" ng-show="!settings.loginrequired || loginOK">
                    <label>Gästeliste</label>
                    <div ng-hide="error" ng-repeat="(key, name) in names" style="margin-bottom: 20px; text-align:left;">
                        <div ng-hide="success">
                            <input class="form-control" type="text" ng-model="names[key].vorname" placeholder="Vorname">
                            <input class="form-control" type="text" ng-model="names[key].name" placeholder="Name">
                            <input class="form-control" type="text" ng-model="names[key].email" placeholder="Email">
                        </div>
                        <div ng-show="success" class="alert alert-success">
                            {{names[key].vorname}} {{names[key].name}} wurde eingetragen.
                        </div>
                    </div>
                    <div ng-hide="success || error" class="btn btn-default" ng-click="addName(); success=false;" style="width: 250px; ">+ weitere Person hinzufügen</div>
                    <br><br>
                    <div ng-show="error" class="alert alert-danger" style="width: 250px; margin-bottom: 20px; text-align:left;">{{error}}<br><a href=".">Neu versuchen</a></div>
                    
                    <label ng-hide="success">
                        <input type="checkbox" ng-model="privacyaccepted">
                        Ich akzeptiere die <a href="privacy.html" target="blank" style="text-decoration: underline">Datenschutzerklärung</a>
                    </label>

                    <div ng-hide="error" class="btn-group-vertical" style="width: 250px; ">
                        <div class="btn btn-primary" ng-click="send();" ng-class="{'btn-success':success}">
                            <span ng-hide="success" class="glyphicon glyphicon-pencil"></span>
                            <span ng-show="success" class="glyphicon glyphicon-ok"></span>
                            {{success?"Bis bald!":"Auf die Gästeliste schreiben"}}                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <script>
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function($scope, $http) {
        $scope.settings = {};
        $scope.names = [];
        $scope.account = {};
        $scope.addName = function(){
            $scope.names.push({name:"", vorname:""});
        }
        $scope.addName();
        $scope.send = function(){
            if($scope.success) return;
            if(!$scope.privacyaccepted) return;
            $http.post("api/insert.php", {names:$scope.names, account:$scope.account})
            .success(function(data){
                if(data) $scope.error = data;
                else $scope.success = true;
            })
            .error(function() {
                $scope.error = "Da ist was schief gelaufen :/ Versuche es später noch einmal";
            })
        }
        $scope.login = function(){
            $http.post("api/login.php",{account:$scope.account})
            .success(function(){
                $scope.loginOK = true;
            })
        }
        $http.post("api/getSettings.php").success(function(d){$scope.settings = d;});
    });
    </script> 
</body>
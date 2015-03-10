<?php
	session_start();
	include_once "top_navi.php";
    ?>

<?php
    $user = $_SESSION['username'];
    $conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
    $dbconn = pg_connect($conn);
    $query = "SELECT sentreceived.sender, messages.messagetext, messages.senton FROM messages, sentreceived WHERE messages.messageid = sentreceived.messageid AND sentreceived.recipient = '$user'";
    $result= pg_query($dbconn, $query);
    $_var = array();
    while ($row =  pg_fetch_row($result)) {
        $_tarr = array(
                       'userName' => $row[1],
                       'body' => $row[2],
                       'createdBy' => $row[1],
                       'sentOn' => $row[3]
                       // ...
                       );
        array_push($_var, $_tarr);
    }
    
    pg_close($dbconn);
    //echo "<p> $_var </p>";
    /*
     $var = array(
     'userName' => $row[1],
     'body' => $row[2],
     'createdBy' => $row[1],
     'sentOn' => $row[3]
     // ...
     );
     */
?>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>SynergySpace</title>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/round-about.css" rel="stylesheet">

<!-- Stylesheets -->
<link href="css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
<script src="http://m-e-conroy.github.io/angular-dialog-service/javascripts/dialogs.min.js" type="text/javascript"></script>

<style>
body {
    padding-top: 31px;
}
</style>
</head>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>SynergySpace</title>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/round-about.css" rel="stylesheet">

<!-- Stylesheets -->
<link href="css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
<script src="http://m-e-conroy.github.io/angular-dialog-service/javascripts/dialogs.min.js" type="text/javascript"></script>

<style>
body {
    padding-top: 31px;
}
</style>
</head>

<body>


<!-- Sidebar -->
<div id="sidebar-wrapper">
<ul class="sidebar-nav">
<li>
<a href="#">UNDECIDED?</a>
</li>

</ul>
</div>

<!-- Page Content -->

<ng ng-app="myApp">

<hr>


<div class="container">
<h1>Messages</h1>

<div class="row" ng-controller="inboxCtrl">
<div class="col-md-10">
<!--inbox toolbar-->
<div class="row" ng-show="!isMessageSelected()">
<div class="col-xs-12 spacer5"></div>
</div><!--/row-->
<!--/inbox toolbar-->
<div class="panel panel-default inbox" id="inboxPanel">
<!--message list-->
<div class="table-responsive" ng-show="!isMessageSelected()">
<table class="table table-striped table-hover refresh-container pull-down">
<thead class="hidden-xs">
<tr>
<td class="col-sm-3"><a href="javascript:;"><strong>Date / Time</strong></a></td>
<td class="col-sm-2"><a href="javascript:;"><strong>Customer</strong></a></td>
<td class="col-sm-4"><a href="javascript:;"><strong>Message</strong></a></td>
<td class="col-sm-1"></td>
</tr></thead>

<tbody><tr ng-repeat="item in pagedItems[currentPage] | orderBy:sortingOrder:reverse">




<td class="col-sm-3 col-xs-4" ng-click="readMessage($index)"><span ng-class="{strong: !item.read}">{{item.sentOn | date:'yyyy-MM-dd hh:mm'}}</span></td>
<td class="col-sm-2 col-xs-4" ng-click="readMessage($index)"><span ng-class="{strong: !item.read}">{{item.userName}}</span></td>
<td class="col-sm-4 col-xs-6" ng-click="readMessage($index)"><span ng-class="{strong: !item.read}">{{item.body}}</span></td>
<td class="col-sm-1 col-sm-2" ng-click="readMessage($index)"><span ng-show="item.attachment" class="glyphicon glyphicon-paperclip pull-right"></span> <span ng-show="item.priority==1" class="pull-right glyphicon glyphicon-warning-sign text-danger"></span></td>
</tr>
</tbody>
</table>
</div>
<!--message detail-->
<div class="container-fluid" ng-show="isMessageSelected()">
<div class="row" ng-controller="messageCtrl">
<div class="col-xs-12">
<h3 title="Go To Inbox"><button type="button" class="close pull-right" ng-click="closeMessage()" aria-hidden="true">~</button><a href="javascript:;" ng-click="groupToPages()">Inbox</a> {{selected.subject}}</h3>
</div>
<div class="col-md-8">
<blockquote>
<strong>{{selected.from}}</strong> &lt;item.createdBy{{selected.fromAddress}}&gt; on 10:14AM, 22 May 2014
</blockquote>
</div>
<div class="col-md-4">
<div class="btn-group btn-group-lg pull-right">
<button class="btn btn-primary" title="Reply to this message" data-toggle="tooltip">
<i class="fa fa-reply"></i> Reply
</button>
</div>
<div class="spacer5 pull-right"></div>
<button class="btn btn-lg btn-primary pull-right" ng-click="deleteItem(selected.$index)" title="Delete this message" data-toggle="tooltip">
<i class="fa fa-trash-o fa-1x"></i>Delete
</button>
</div>
<div class="col-xs-12"><hr></div>
<div class="col-xs-12">
<!--message body-->
<div ng-bind-html="renderMessageBody(selected.body)"></div>
<!--/message body-->
</div>

</div><!--/row-->
</div>
</div><!--/inbox panel-->
<div class="well well-s text-right"><em>Last updated: <span id="lastUpdated">{{date | date:'MM-dd-yyyy HH:mm:ss'}}</span></em></div>

<hr>

</div><!--/col-9-->
    
<!-- /.modal compose message -->
<div class="modal fade" id="modalCompose">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">~</button>
<h4 class="modal-title">Compose Message</h4>
</div>
<div class="modal-body">
<form role="form" class="form-horizontal">
<div class="form-group">
<label class="col-sm-2" for="inputTo">To</label>
<div class="col-sm-10"><input type="email" class="form-control" id="inputTo" placeholder="comma separated list of recipients"></div>
</div>
<div class="form-group">
<label class="col-sm-2" for="inputSubject">Subject</label>
<div class="col-sm-10"><input type="text" class="form-control" id="inputSubject" placeholder="subject"></div>
</div>
<div class="form-group">
<label class="col-sm-12" for="inputBody">Message</label>
<div class="col-sm-12"><textarea class="form-control" id="inputBody" rows="12"></textarea></div>
</div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-warning pull-left">Save Draft</button>
<button type="button" class="btn btn-primary ">Send <i class="fa fa-arrow-circle-right fa-lg"></i></button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal compose message -->
<div><!--/row ng-controller-->

</div><!--/container-->

</div>

</div>
</ng>


<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Menu Toggle Script -->
<script>
$("#menu-toggle").click(function(e) {
                        e.preventDefault();
                        $("#wrapper").toggleClass("toggled");
                        });
</script>

<!-- Toggle the visibility of an object given its id. -->
<script>
function toggleVisibility(id) {
    var object = document.getElementById(id);
    if (object.style.visibility == "hidden") {
        object.style.visibility = "visible";
    }
    else {
        object.style.visibility = "hidden";
    }
}
</script>

<script type="text/javascript">
var messages = <?php
    $jaysoon = "[";
    foreach($_var as &$message) {
        $_tvar = jason_encode($message);
        $_tvar .= ", ";
        $jaysoon .= json_encode($_tvar);
    }
    $jaysoon = substr($jaysoon, 0, -1);
    $jaysoon .= "]";
    ?>;
console.log(5+6);

</script>

<script type="text/javascript">

//begin

//alert( varNameSpace.prop1 ); // -> 'value1'
//echo json_encode($var);


//end
var app = angular.module("myApp",[]);

//var messages = [{"userName": "Username", "body": "message body test", "createdBy": "created by test", "sentOn": "2014-09-02T21:16:15.843"}, {"userName": "Username1", "body": "message body test1", "createdBy": "created by test", "sentOn": "2014-09-02T21:16:15.842"}, {"userName": "Username2", "body": "message body test1", "createdBy": "created by test", "sentOn": "2014-09-02T21:16:15.842"}];

//var messages = [{ "messageId": "26bd9a57-7c50-48bc-85f4-267693aa14c2", "externalId": "SMeb952462b0d5407a8e0015ed34145717", "companyId": 13, "direction": 0, "customerNumber": "+17273314889", "dealershipNumber": "+17272402455", "body": "another test", "status": 6, "errorCode": null, "createdOn": "2014-09-02T21:14:04.447", "createdBy": null, "updatedOn": "2014-09-02T21:16:15.843", "sentOn": "2014-09-02T21:16:15.843" }, { "messageId": "d1b71bd9-c83d-4876-a27d-acf798604f60", "externalId": "SM652a9a21bf7f49c29dbb3b29e19f9f7f", "companyId": 13, "direction": 0, "customerNumber": "+17273314889", "dealershipNumber": "+17272402455", "body": "Hello Again4", "status": 6, "errorCode": null, "createdOn": "2014-08-26T22:26:05.997", "createdBy": null, "updatedOn": "2014-08-27T18:15:59.723", "sentOn": "2014-08-27T18:15:59.723" }, { "messageId": "75a9322a-e695-41ae-af3c-766364c6c87b", "externalId": "SM3b30488ea29e11ce0d0b6ab57fc86957", "companyId": 13, "direction": 1, "customerNumber": "+17273314889", "dealershipNumber": "+17272402455", "body": "Test reply", "status": 5, "errorCode": null, "createdOn": "2014-08-26T22:23:32.08", "createdBy": null, "updatedOn": "2014-08-26T22:23:32.08", "sentOn": "2014-08-26T22:23:32.08" }, { "messageId": "625ef260-7371-48a2-8cda-f1e9eb3edff9", "externalId": "SM9a505ebde1814c5a87946ab9e7a7e207", "companyId": 13, "direction": 0, "customerNumber": "+17273314889", "dealershipNumber": "+17272402455", "body": "Hello Again3", "status": 6, "errorCode": null, "createdOn": "2014-08-26T22:03:23.52", "createdBy": null, "updatedOn": "2014-08-27T18:15:41.037", "sentOn": "2014-08-27T18:15:41.037" }, { "messageId": "3fd2d24b-232a-47f7-bce6-e3ca437a5005", "externalId": "SMa7dd6b2b880b4b82a499d102dcaf0da6", "companyId": 13, "direction": 0, "customerNumber": "+17273314889", "dealershipNumber": "+17272402455", "body": "Hello Again", "status": 6, "errorCode": null, "createdOn": "2014-08-26T19:23:17.633", "createdBy": null, "updatedOn": "2014-08-27T18:15:22.093", "sentOn": "2014-08-27T18:15:22.093" }, { "messageId": "a4024f5f-7869-439c-b234-17655d072d8e", "externalId": "SMbe554efc0ebf43b0a989eca9d8b12784", "companyId": 13, "direction": 0, "customerNumber": "+17273314889", "dealershipNumber": "+17272402455", "body": "Hello Back", "status": 6, "errorCode": null, "createdOn": "2014-08-26T19:01:07.977", "createdBy": null, "updatedOn": "2014-08-27T18:14:24.367", "sentOn": "2014-08-27T18:14:24.367" }, { "messageId": "ad63a28e-943e-48fe-ae00-e51de9f3d88f", "externalId": "SMa79c1205a78d064d1660f6b05f2699c4", "companyId": 13, "direction": 1, "customerNumber": "+17273314889", "dealershipNumber": "+17272402455", "body": "Test", "status": 0, "errorCode": null, "createdOn": "2014-08-26T18:51:04", "createdBy": null, "updatedOn": "2014-08-26T18:51:04", "sentOn": "2014-08-26T18:51:04" }];

app.controller('inboxCtrl', ['$scope', '$filter', function ($scope, $filter) {
               
               
               $scope.date = new Date;
               $scope.sortingOrder = 'id';
               $scope.pageSizes = [10,20,50,100];
               $scope.reverse = false;
               $scope.filteredItems = [];
               $scope.groupedItems = [];
               $scope.itemsPerPage = 10;
               $scope.pagedItems = [];
               $scope.currentPage = 0;
               
               /* inbox functions -------------------------------------- */
               
               // get data and init the filtered items
               $scope.init = function () {
               
               $scope.items = messages;
               $scope.search();
               
               }
               
               var searchMatch = function (haystack, needle) {
               if (!needle) {
               return true;
               }
               return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
               };
               
               // filter the items
               $scope.search = function () {
               $scope.filteredItems = $filter('filter')($scope.items, function (item) {
                                                        for(var attr in item) {
                                                        if (searchMatch(item[attr], $scope.query))
                                                        return true;
                                                        }
                                                        return false;
                                                        });
               $scope.currentPage = 0;
               // now group by pages
               $scope.groupToPages();
               };
               
               // calculate page in place
               $scope.groupToPages = function () {
               $scope.selected = null;
               $scope.pagedItems = [];
               
               for (var i = 0; i < $scope.filteredItems.length; i++) {
               if (i % $scope.itemsPerPage === 0) {
               $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [ $scope.filteredItems[i] ];
               } else {
               $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
               }
               }
               };
               
               $scope.range = function (start, end) {
               var ret = [];
               if (!end) {
               end = start;
               start = 0;
               }
               for (var i = start; i < end; i++) {
               ret.push(i);
               }
               return ret;
               };
               
               $scope.prevPage = function () {
               if ($scope.currentPage > 0) {
               $scope.currentPage--;
               }
               return false;
               };
               
               $scope.nextPage = function () {
               if ($scope.currentPage < $scope.pagedItems.length - 1) {
               $scope.currentPage++;
               }
               return false;
               };
               
               $scope.setPage = function () {
               $scope.currentPage = this.n;
               };
               
               $scope.deleteItem = function (idx) {
               var itemToDelete = $scope.pagedItems[$scope.currentPage][idx];
               var idxInItems = $scope.items.indexOf(itemToDelete);
               $scope.items.splice(idxInItems,1);
               $scope.search();
               
               return false;
               };
               
               $scope.isMessageSelected = function () {
               if (typeof $scope.selected!=="undefined" && $scope.selected!==null) {
               return true;
               }
               else {
               return false;
               }
               };
               
               $scope.readMessage = function (idx) {
               $scope.items[idx].read = true;
               $scope.selected = $scope.items[idx];
               };
               
               $scope.readAll = function () {
               for (var i in $scope.items) {
               $scope.items[i].read = true;
               }
               };
               
               $scope.closeMessage = function () {
               $scope.selected = null;
               };
               
               $scope.renderMessageBody = function(html)
               {
               return html;
               };
               
               /* end inbox functions ---------------------------------- */
               
               
               // initialize
               $scope.init();
               
               }])// end inboxCtrl
.controller('messageCtrl', ['$scope', function ($scope) {
            
            $scope.message = function(idx) {
            return messages(idx);
            };
            
            }]);// end messageCtrl


//$(document).ready(function(){});
</script>
</body>
</html>


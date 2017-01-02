var listApp = angular.module('listpp', []);

listApp.controller('mysqlCtrl', function ($scope, $http) {
    $scope.filteredItems = [];
    $scope.groupedItems = [];
    $scope.itemsPerPage = 3;
    $scope.pagedItems = [];
    $scope.currentPage = 0;
    $scope.menuState = false;
    $scope.add_room = true;
    $scope.showModal = false;

    $scope.toggleMenu = function () {
        if ($scope.menuState) {
            $scope.menuState = false;
        } else {
            $scope.menuState = !$scope.menuState.show;
        }
    };

    $scope.get_room = function () {
        $http.get("db.php?action=get_room").success(function (data)
        {
            $scope.pagedItems = data;
            console.log(data[0]);
        });
    };

    $scope.room_submit = function () {
        $http.post('db.php?action=add_room', {
            'room_number': $scope.room_number
        })
                .success(function (data, status, headers, config) {
                    $scope.get_room();
                    $scope.room_number = null;
                    var log = console.log(data);
                })
                .error(function (data, status, headers, config) {
                });
    };

    $scope.room_delete = function (index) {
        $http.post('db.php?action=delete_room', {
            'prod_index': index
        })
                .success(function (data, status, headers, config) {
                    $scope.get_room();
                })
                .error(function (data, status, headers, config) {
                });
    };

    $scope.room_edit = function (index) {

        $scope.update_room = true;
        $scope.add_room = false;
        $http.post('db.php?action=edit_room',
                {
                    'prod_index': index
                })
                .success(function (data, status, headers, config) {
                    $scope.prod_id = data[0]["id"];
                    $scope.room_number = data[0]["room_number"];
                })
                .error(function (data, status, headers, config) {
                    console.log("Unable to edit the room detail");
                });
    };

    $scope.room_update = function () {
        console.log("Room update " + $scope.prod_id);
        $http.post('db.php?action=update_room',
                {
                    'id': $scope.prod_id,
                    'room_number': $scope.room_number
                })
                .success(function (data, status, headers, config) {
                    $scope.get_room();
                    $scope.update_room = false;
                    $scope.add_room = true;
                    $scope.room_number = null;
                })
                .error(function (data, status, headers, config) {
                    console.log("Unable to update");
                });
    };

    $scope.room_book = function (index) {
        console.log("Booking room");
        $http.post('db.php?action=book_room',
                {
                    'prod_index': index
                })
                .success(function (data, status, headers, config) {
                    $scope.get_room();
                    console.log("room booked");
                })
                .error(function (data, status, headers, config) {
                    console.log("Unable to book the room");
                });
    };

    $scope.room_booking_cancel = function (index) {
        console.log("Cancel room booking ");
        $http.post('db.php?action=cancel_booking',
                {
                    'prod_index': index
                })
                .success(function (data, status, headers, config) {
                    $scope.get_room();
                    console.log("Room booking cancel Successfully");
                })
                .error(function (data, status, headers, config) {
                    console.log("Unable to book the room");
                });
    };

});

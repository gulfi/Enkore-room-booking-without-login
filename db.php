<?php

include('config.php');

switch ($_GET['action']) {
    case 'add_room' :
        add_room();
        break;

    case 'get_room' :
        get_room();
        break;

    case 'edit_room' :
        edit_room();
        break;

    case 'delete_room' :
        delete_room();
        break;

    case 'update_room' :
        update_room();
        break;

    case 'book_room' :
        book_room();
        break;

    case 'cancel_booking' :
        cancel_booking();
        break;
}

function add_room() {
    $data = json_decode(file_get_contents("php://input"));
    $room_number = $data->room_number;
    $qry = 'INSERT INTO enkore (room_number) values ("' . $room_number . '")';
    $qry_res = mysql_query($qry);
    if ($qry_res) {
        $arr = array('msg' => "Room Added Successfully!!!", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    } else {
        $arr = array('msg' => "", 'error' => 'Error In inserting record');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}

function get_room() {
    $qry = mysql_query('SELECT * from enkore');
    $data = array();
    while ($rows = mysql_fetch_array($qry)) {
        $data[] = array(
            "id" => $rows['id'],
            "room_number" => $rows['room_number'],
            "status" => $rows['status']
        );
    }
    print_r(json_encode($data));
    return json_encode($data);
}

function delete_room() {
    $data = json_decode(file_get_contents("php://input"));
    $index = $data->prod_index;
    print_r($index);
    $del = mysql_query("DELETE FROM enkore WHERE id = " . $index);
    if ($del) {
        return true;
    }
    return false;
}

function edit_room() {
    $data = json_decode(file_get_contents("php://input"));
    $index = $data->prod_index;
    $qry = mysql_query('SELECT * from enkore WHERE id=' . $index);
    $data = array();
    while ($rows = mysql_fetch_array($qry)) {
        $data[] = array(
            "id" => $rows['id'],
            "room_number" => $rows['room_number'],
        );
    }
    print_r(json_encode($data));
    return json_encode($data);
}

function update_room() {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $room_number = $data->room_number;
    $qry = "UPDATE enkore SET room_number='" . $room_number . "'WHERE id=" . $id;
    $qry_res = mysql_query($qry);
    if ($qry_res) {
        $arr = array('msg' => "Room Updated Successfully", 'error' => '');
        $jsn = json_encode($arr);
    } else {
        $arr = array('msg' => "", 'error' => 'Error In Updating room number');
        $jsn = json_encode($arr);
    }
}

function book_room() {
    $data = json_decode(file_get_contents("php://input"));
    $index = $data->prod_index;
    $book = mysql_query("UPDATE enkore SET status = 1 WHERE id = " . $index);
    if ($book) {
        return true;
    }
    return false;
}

function cancel_booking() {
    //echo "<script>alert('There are no fields to generate a report');</script>";
    $data = json_decode(file_get_contents("php://input"));
    $index = $data->prod_index;
    $book = mysql_query("UPDATE enkore SET status = 0 WHERE id = " . $index);
    if ($book) {
        return true;
    }
    return false;
}

<?php

namespace Se7entech\Contractnew\Modules\Tasks\Models;

use Se7entech\Contractnew\Helpers\EscapeString;

class TaskLabelModel {
    private static $table = 'task_labels';
    private static $taskLablesTasks = 'task_labels_tasks';

    // Get all labels
    public static function getAll() {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT id, name, background_color, text_color FROM " . self::$table . " ORDER BY id ASC";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }
        return $response;
    }

    // Get label by id
    public static function getById($id) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT id, name, background_color, text_color FROM " . self::$table . " WHERE id='" . intval($id) . "'";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }
        return $response;
    }

    // Create a new label
    public static function postLabel($data) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table . " (name, background_color, text_color) VALUES ('" . $data['label-name'] . "', '" . $data['label-background-color'] . "', '" . $data['label-text-color'] . "')";
        $result = mysqli_query($con, $sql);
        return array('success' => $result, 'id' => mysqli_insert_id($con));
    }

    // Update a label
    public static function updateLabel($id, $data) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET name='" . $data['label-name'] . "', background_color='" . $data['label-background-color'] . "', text_color='" . $data['label-text-color'] . "' WHERE id=" . intval($id);
        return (mysqli_query($con, $sql));
    }

    // Delete a label and its associations in task_labels_tasks
    public static function delete($id) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        // Delete associations in task_labels_tasks
        $sqlAssoc = "DELETE FROM " . self::$taskLablesTasks . " WHERE id_task_label=" . intval($id);
        mysqli_query($con, $sqlAssoc);

        // Delete the label itself
        $sql = "DELETE FROM " . self::$table . " WHERE id=" . intval($id);
        $res = mysqli_query($con, $sql);

        return $res;
    }

    // Get all labels for a specific task
    public static function getLabelsByTaskId($taskId) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT l.id, l.name, l.color FROM " . self::$table . " tl 
                JOIN " . self::$taskLablesTasks . " l ON tl.task_label_id = l.id 
                WHERE tl.task_id = " . intval($taskId);
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }
        return $response;
    }

    // Assign a label to a task
    public static function assignLabelToTask($taskId, $labelId) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "INSERT INTO " . self::$table . " (task_id, task_label_id) VALUES (" . intval($taskId) . ", " . intval($labelId) . ")";
        return mysqli_query($con, $sql);
    }

    // Remove a label from a task
    public static function removeLabelFromTask($taskId, $labelId) {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "DELETE FROM " . self::$table . " WHERE task_id=" . intval($taskId) . " AND task_label_id=" . intval($labelId);
        return mysqli_query($con, $sql);
    }
}

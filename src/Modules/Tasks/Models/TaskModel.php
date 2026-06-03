<?php

namespace Se7entech\Contractnew\Modules\Tasks\Models;

use Se7entech\Contractnew\Helpers\EscapeString;

class TaskModel
{
    private static $table = 'tasks';
    private static $taskLabelTable = 'task_labels';
    private static $taskCategoryTable = 'task_categories';
    // This table is used to link tasks with labels
    private static $taskLablesTasks = 'task_labels_tasks';
    private static $taskCategoriesTasks = 'task_categories_tasks';

    public static function getAll()
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT 
            tasks.id, 
            tasks.customer_tempname, 
            tasks.asigned_to, 
            tasks.name, 
            tasks.description, 
            tasks.status, 
            tasks.start_time, 
            tasks.end_time, 
            tasks.pause_intervals, 
            tasks.total_pauses, 
            tasks.total_time, 
            tasks.task_description_for_customer,
            tasks.custom_total_time,
            tasks.estimated_time,
            tasks.created_at, 
            invoice_user.email, 
            invoice_user.first_name, 
            invoice_user.last_name,
            customers.name AS customer_name,
            customers.business_name AS customer_business_name,
            GROUP_CONCAT(" . self::$taskLabelTable . ".id) AS labels
            FROM " . self::$table . "
            LEFT JOIN invoice_user ON tasks.asigned_to = invoice_user.id
            LEFT JOIN customers ON tasks.customer_id = customers.id
            LEFT JOIN " . self::$taskLablesTasks . " ON tasks.id = " . self::$taskLablesTasks . ".id_task
            LEFT JOIN " . self::$taskLabelTable . " ON " . self::$taskLablesTasks . ".id_task_label = " . self::$taskLabelTable . ".id
            GROUP BY tasks.id
            ORDER BY tasks.id ASC";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }

        return $response;
    }

    public static function getById($id)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        $response = array();
        $sql = "SELECT 
                tasks.id, 
                tasks.customer_tempname, 
                tasks.customer_id, 
                tasks.asigned_to, 
                tasks.name, 
                tasks.description, 
                tasks.status, 
                tasks.start_time, 
                tasks.end_time, 
                tasks.pause_intervals, 
                tasks.pause_reasons, 
                tasks.total_pauses, 
                tasks.total_time, 
                tasks.deadline,
                tasks.estimated_time,
                tasks.custom_total_time,
                tasks.task_description_for_customer,
                tasks.project_id,
                tasks.created_at, 
                tasks.final_resource,
                invoice_user.email, 
                invoice_user.first_name, 
                invoice_user.last_name, 
                customers.name as customer_name, 
                customers.business_name as customer_business_name,
                GROUP_CONCAT(" . self::$taskLabelTable . ".id) AS labels,
                GROUP_CONCAT(" . self::$taskCategoryTable . ".id) AS categories
            FROM " . self::$table . "
            LEFT JOIN invoice_user ON tasks.asigned_to = invoice_user.id
            LEFT JOIN customers ON tasks.customer_id = customers.id
            LEFT JOIN " . self::$taskLablesTasks . " ON tasks.id = " . self::$taskLablesTasks . ".id_task
            LEFT JOIN " . self::$taskLabelTable . " ON " . self::$taskLablesTasks . ".id_task_label = " . self::$taskLabelTable . ".id
            LEFT JOIN " . self::$taskCategoriesTasks . " ON tasks.id = " . self::$taskCategoriesTasks . ".task_id
            LEFT JOIN " . self::$taskCategoryTable . " ON " . self::$taskCategoriesTasks . ".category_id = " . self::$taskCategoryTable . ".id";
        $sql .= " WHERE tasks.id='" . $id . "' GROUP BY tasks.id ORDER BY tasks.created_at DESC";

        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }

        return $response;
    }

    public static function postTask($data)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table . " 
        (
            asigned_to, name, 
            status, customer_id, 
            description, customer_tempname,
            project_id, deadline, estimated_time,
            task_description_for_customer
        ) VALUES (
         '" . $data['task-user'] . "',
         '" . $data['task-name'] . "',
         'created', 
         '" . $data['customer-id'] . "',
         '" . $data['task-description'] . "',
         '" . $data['customer-tempname'] . "',
         '" . $data['task-project'] . "',
         '" . $data['deadline'] . "',
         '" . $data['estimated_time'] . "',
         '" . $data['task-description-for-customer'] . "'
        )";

        $result = mysqli_query($con, $sql);

        if ($result) {
            $insertedTaskId = mysqli_insert_id($con);

            if (isset($data['task-labels']) && is_array($data['task-labels']) && (count($data['task-labels']) > 0)) {
                // Ensure task labels are escaped and inserted
                $data['task-labels'] = $data['task-labels'];
            } else {
                $data['task-labels'] = array();
            }
            if (isset($data['task-categories']) && is_array($data['task-categories']) && (count($data['task-categories']) > 0)) {
                // Ensure task categories are escaped and inserted
                $data['task-categories'] = $data['task-categories'];
            } else {
                $data['task-categories'] = array();
            }

            foreach ($data['task-labels'] as $label) {
                $sql = "INSERT INTO " . self::$taskLablesTasks . " (id_task, id_task_label) VALUES (" . $insertedTaskId . ", '$label')";
                mysqli_query($con, $sql);
            }

            foreach ($data['task-categories'] as $category) {
                $sql = "INSERT INTO " . self::$taskCategoriesTasks . " (task_id, category_id) VALUES (" . $insertedTaskId . ", '$category')";
                mysqli_query($con, $sql);
            }
        }

        return array('success' => $result, 'id' => $insertedTaskId);
    }

    public static function updateTask($id, $data)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET name='" . $data['task-name'] . "', 
            description='" . $data['task-description'] . "', 
            asigned_to='" . $data['task-user'] . "', 
            customer_id='" . $data['customer-id'] . "', 
            customer_tempname='" . $data['customer-tempname'] . "', 
            project_id='" . ($data['task-project']) . "',
            deadline='" . $data['deadline'] . "',
            estimated_time='" . $data['estimated_time'] . "',
            custom_total_time='" . $data['custom_total_time'] . "',
            task_description_for_customer='" . $data['task-description-for-customer'] . "'";
        if (isset($data['created_at']) && $data['created_at'] !== '') {
            $sql .= ", created_at='" . $data['created_at'] . "'";
        }
        $sql .= " WHERE id=$id";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            return false; // If the update fails, return false
        }
        // If the update is successful, we proceed to handle labels
        // delete all labels for this task, then insert new ones
        $deleteLabelsSql = "DELETE FROM " . self::$taskLablesTasks . " WHERE id_task=$id";
        mysqli_query($con, $deleteLabelsSql);
        if (isset($data['task-labels']) && is_array($data['task-labels']) && (count($data['task-labels']) > 0)) {
            // Ensure task labels are escaped and inserted
            $data['task-labels'] = $data['task-labels'];
        } else {
            $data['task-labels'] = array();
        }
        foreach ($data['task-labels'] as $label) {
            $sql = "INSERT INTO " . self::$taskLablesTasks . " (id_task, id_task_label) VALUES ($id, '$label')";
            mysqli_query($con, $sql);
        }

        // If the update is successful, we proceed to handle categories
        // delete all categories for this task, then insert new ones
        $deleteCategoriesSql = "DELETE FROM " . self::$taskCategoriesTasks . " WHERE task_id=$id";
        mysqli_query($con, $deleteCategoriesSql);
        if (isset($data['task-categories']) && is_array($data['task-categories']) && (count($data['task-categories']) > 0)) {
            // Ensure task labels are escaped and inserted TODO
            $data['task-categories'] = $data['task-categories'];
        } else {
            $data['task-categories'] = array();
        }
        foreach ($data['task-categories'] as $category) {
            $sql = "INSERT INTO " . self::$taskCategoriesTasks . " (task_id, category_id) VALUES ($id, '$category')";
            mysqli_query($con, $sql);
        }

        return $result;
    }

    public static function pauseTask($id, $data)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET pause_intervals='" . $data['pause_intervals'] . "', pause_reasons='" . $data['pause_reasons'] . "', status='" . $data['status'] . "' WHERE id=$id";

        return (mysqli_query($con, $sql));
    }

    public static function resumeTask($id, $data)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET pause_intervals='" . $data['pause_intervals'] . "', status='" . $data['status'] . "', total_pauses='" . $data['total_pauses'] . "' WHERE id=$id";

        return (mysqli_query($con, $sql));
    }

    public static function startTask($id, $data)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET start_time='" . $data['start_time'] . "', status='" . $data['status'] . "' WHERE id=$id";

        return (mysqli_query($con, $sql));
    }

    public static function finishTask($id, $data)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET end_time='" . $data['end_time'] . "', status='" . $data['status'] . "', total_time='" . $data['total_time'] . "', total_pauses='" . $data['total_pauses'] . "', final_resource='" . $data['final_resource'] . "' WHERE id=$id";

        return (mysqli_query($con, $sql));
    }

    public static function reopenTask($id, $data)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET status='" . $data['status'] . "', total_time=" . $data['total_time'] . ", end_time=" . $data['end_time'] . " WHERE id=$id";

        return (mysqli_query($con, $sql));
    }

    public static function delete($id)
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        // First, delete all label links for this task
        $deleteLabelsSql = "DELETE FROM " . self::$taskLablesTasks . " WHERE id_task=$id";
        mysqli_query($con, $deleteLabelsSql);

        // Then, delete the task itself
        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }

    public static function getCustomerTasks($customer_id)
    {
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "SELECT * FROM " . self::$table . " WHERE customer_id = '" . $customer_id . "'";
        $res = mysqli_query($con, $sql);

        $response = array();
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }

        return $response;

    }
    public static function apiGetTasks($filters = [])
    {
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        $where = ["1=1"];

        if (isset($filters['status']) && !empty($filters['status'])) {
            $status = EscapeString::escapeValue($con, $filters['status']);
            $where[] = "tasks.status = '$status'";
        }

        if (isset($filters['user_id']) && !empty($filters['user_id'])) {
            $user_id = EscapeString::escapeValue($con, $filters['user_id']);
            $where[] = "tasks.asigned_to = '$user_id'";
        }

        if (isset($filters['customer_id']) && !empty($filters['customer_id'])) {
            $customer_id = EscapeString::escapeValue($con, $filters['customer_id']);
            $where[] = "tasks.customer_id = '$customer_id'";
        }

        // Filtering by label or category requires special handling due to joins
        // We will add specific WHERE clauses if these filters are present
        if (isset($filters['label_id']) && !empty($filters['label_id'])) {
            $label_id = EscapeString::escapeValue($con, $filters['label_id']);
            // We need a subquery or join condition to ensure we only get tasks with this label
            $where[] = "tasks.id IN (SELECT id_task FROM " . self::$taskLablesTasks . " WHERE id_task_label = '$label_id')";
        }

        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            $category_id = EscapeString::escapeValue($con, $filters['category_id']);
            $where[] = "tasks.id IN (SELECT task_id FROM " . self::$taskCategoriesTasks . " WHERE category_id = '$category_id')";
        }

        $whereClause = implode(' AND ', $where);

        $response = array();
        $sql = "SELECT 
            tasks.id, 
            tasks.customer_tempname, 
            tasks.asigned_to, 
            tasks.name, 
            tasks.description, 
            tasks.status, 
            tasks.start_time, 
            tasks.end_time, 
            tasks.pause_intervals, 
            tasks.total_pauses, 
            tasks.total_time, 
            tasks.task_description_for_customer,
            tasks.custom_total_time,
            tasks.estimated_time,
            tasks.created_at, 
            invoice_user.email, 
            invoice_user.first_name, 
            invoice_user.last_name,
            GROUP_CONCAT(DISTINCT " . self::$taskLabelTable . ".id) AS labels,
            GROUP_CONCAT(DISTINCT " . self::$taskCategoryTable . ".id) AS categories
            FROM " . self::$table . "
            LEFT JOIN invoice_user ON tasks.asigned_to = invoice_user.id
            LEFT JOIN " . self::$taskLablesTasks . " ON tasks.id = " . self::$taskLablesTasks . ".id_task
            LEFT JOIN " . self::$taskLabelTable . " ON " . self::$taskLablesTasks . ".id_task_label = " . self::$taskLabelTable . ".id
            LEFT JOIN " . self::$taskCategoriesTasks . " ON tasks.id = " . self::$taskCategoriesTasks . ".task_id
            LEFT JOIN " . self::$taskCategoryTable . " ON " . self::$taskCategoriesTasks . ".category_id = " . self::$taskCategoryTable . ".id
            WHERE $whereClause
            GROUP BY tasks.id
            ORDER BY tasks.id DESC";

        $res = mysqli_query($con, $sql);
        if ($res && mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }

        return $response;
    }
}
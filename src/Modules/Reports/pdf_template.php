<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Work Report</title>
    <style>
        body, p, td, th, h1, h2, h3, span, div, strong, b, em, i, a { font-family: "DejaVu Sans", Helvetica, Arial, sans-serif; line-height: 1.4em; }
        body { color: #333; padding: 10px; font-size: 11px; }
        h1 { margin: 0; color: #2c646c; font-size: 20px; }
    </style>
</head>
<body>
    <!-- Header Table -->
    <?php
    $logoPath = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo.png';
    $logoSrc = 'https://se7entech.net/images/logo.png'; // Fallback
    if (file_exists($logoPath)) {
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoData;
    }
    ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-bottom: 2px solid #0daea8; padding-bottom: 10px; margin-bottom: 20px;">
        <tr>
            <td width="50%" valign="middle">
                <img src="<?php echo $logoSrc; ?>" alt="SE7ENTECH" style="height: 35px; width: 130px;">
            </td>
            <td width="50%" valign="middle" align="right" style="line-height: 16px;">
                <strong style="color: #2c646c; font-size: 20px; line-height: 24px;">WORK REPORT</strong><br/>
                <span style="color: #777; font-size: 11px; line-height: 15px;">Period: <?php echo date('M d, Y', strtotime($startDate)); ?> to <?php echo date('M d, Y', strtotime($endDate)); ?></span>
            </td>
        </tr>
    </table>

    <!-- Info Table -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 20px;">
        <tr>
            <td width="50%" valign="top" style="line-height: 15px;">
                <strong style="color: #2c646c; font-size: 11px;">From:</strong><br/>
                <strong style="font-size: 11px;">SE7ENTECH</strong><br/>
                <span style="color: #555; font-size: 11px;">460 Irving Park RD, STE C123</span><br/>
                <span style="color: #555; font-size: 11px;">Bensenville, IL 60106</span><br/>
                <span style="color: #555; font-size: 11px;">info@se7entech.net</span>
            </td>
            <td width="50%" valign="top" style="padding-left: 20px; line-height: 15px;">
                <strong style="color: #2c646c; font-size: 11px;">Prepared For:</strong><br/>
                <strong style="font-size: 11px;"><?php echo htmlspecialchars($customer['business_name'] ? $customer['business_name'] : $customer['name']); ?></strong><br/>
                <span style="color: #555; font-size: 11px;"><?php echo htmlspecialchars($customer['name']); ?></span><br/>
                <span style="color: #555; font-size: 11px;"><?php echo htmlspecialchars($customer['address']); ?></span>
            </td>
        </tr>
    </table>

    <!-- Executive Summary -->
    <?php if (!empty($executiveSummary)): ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 20px; background-color: #f7f9fa; border-left: 4px solid #0daea8;">
        <tr>
            <td style="padding: 12px; line-height: 15px;">
                <strong style="color: #2c646c; font-size: 12px;">Executive Summary</strong><br/>
                <span style="color: #333; font-size: 11px; line-height: 15px;"><?php echo nl2br(htmlspecialchars($executiveSummary)); ?></span>
            </td>
        </tr>
    </table>
    <?php endif; ?>

    <?php
    $totalHours = 0;

    // Render Projects
    if (!empty($reportData['projects'])):
        foreach ($reportData['projects'] as $project):
            if (empty($project['tasks'])) continue;
            $projectHours = 0;
    ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 25px;">
        <tr>
            <td colspan="2" style="border-bottom: 1px solid #0daea8; padding-bottom: 5px;">
                <strong style="color: #0daea8; font-size: 14px;">Project: <?php echo htmlspecialchars($project['name']); ?></strong>
            </td>
        </tr>
        <?php if (!empty($project['description'])): ?>
        <tr>
            <td colspan="2" style="padding: 5px 0 10px 0; color: #666; font-size: 10px; line-height: 14px;">
                <?php echo htmlspecialchars($project['description']); ?>
            </td>
        </tr>
        <?php endif; ?>
        
        <?php foreach ($project['tasks'] as $task): 
            $taskDesc = isset($professionalTasks[$task['id']]) ? $professionalTasks[$task['id']] : 
                       (!empty($task['task_description_for_customer']) ? $task['task_description_for_customer'] : $task['description']);
            $taskDesc = strip_tags(html_entity_decode($taskDesc));
            $hours = \Se7entech\Contractnew\Helpers\TaskHelper::getRealTotalTime($task, true);
            $projectHours += $hours;
            $totalHours += $hours;
        ?>
        <tr>
            <td width="75%" valign="top" style="line-height: 15px; padding: 10px 0; border-bottom: 1px solid #eef2f4;">
                <strong style="color: #2c646c; font-size: 11px;"><?php echo htmlspecialchars($task['name']); ?></strong>
                <span style="color:#aaa; font-size: 8px; margin-left: 8px;"><?php echo date('M d, Y', strtotime($task['created_at'])); ?></span><br/>
                <span style="color: #555; font-size: 10px; line-height: 14px;"><?php echo nl2br(htmlspecialchars($taskDesc)); ?></span>
            </td>
            <td width="25%" valign="top" align="right" style="line-height: 15px; padding: 10px 0 10px 10px; border-bottom: 1px solid #eef2f4;">
                <span style="color: #777; font-size: 9px;">Assigned: <?php 
                    $assignedTo = trim($task['first_name'] . ' ' . $task['last_name']);
                    echo htmlspecialchars(!empty($assignedTo) ? $assignedTo : 'Unassigned'); 
                ?></span><br/>
                <strong style="color: #0daea8; font-size: 11px;"><?php echo number_format($hours, 1); ?> h</strong>
            </td>
        </tr>
        <?php endforeach; ?>
        
        <tr>
            <td colspan="2" align="right" style="padding-top: 10px;">
                <strong style="color: #2c646c; font-size: 11px;">Project Total: <?php echo number_format($projectHours, 1); ?> h</strong>
            </td>
        </tr>
    </table>
    <?php
        endforeach;
    endif;
    ?>

    <?php if (!empty($reportData['no_project_tasks'])): ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 25px;">
        <tr>
            <td colspan="2" style="border-bottom: 1px solid #0daea8; padding-bottom: 5px;">
                <strong style="color: #0daea8; font-size: 14px;">General / Uncategorized Tasks</strong>
            </td>
        </tr>
        
        <?php 
        $projectHours = 0;
        foreach ($reportData['no_project_tasks'] as $task): 
            $taskDesc = isset($professionalTasks[$task['id']]) ? $professionalTasks[$task['id']] : 
                       (!empty($task['task_description_for_customer']) ? $task['task_description_for_customer'] : $task['description']);
            $taskDesc = strip_tags(html_entity_decode($taskDesc));
            $hours = \Se7entech\Contractnew\Helpers\TaskHelper::getRealTotalTime($task, true);
            $projectHours += $hours;
            $totalHours += $hours;
        ?>
        <tr>
            <td width="75%" valign="top" style="line-height: 15px; padding: 10px 0; border-bottom: 1px solid #eef2f4;">
                <strong style="color: #2c646c; font-size: 11px;"><?php echo htmlspecialchars($task['name']); ?></strong>
                <span style="color:#aaa; font-size: 8px; margin-left: 8px;"><?php echo date('M d, Y', strtotime($task['created_at'])); ?></span><br/>
                <span style="color: #555; font-size: 10px; line-height: 14px;"><?php echo nl2br(htmlspecialchars($taskDesc)); ?></span>
            </td>
            <td width="25%" valign="top" align="right" style="line-height: 15px; padding: 10px 0 10px 10px; border-bottom: 1px solid #eef2f4;">
                <span style="color: #777; font-size: 9px;">Assigned: <?php 
                    $assignedTo = trim($task['first_name'] . ' ' . $task['last_name']);
                    echo htmlspecialchars(!empty($assignedTo) ? $assignedTo : 'Unassigned'); 
                ?></span><br/>
                <strong style="color: #0daea8; font-size: 11px;"><?php echo number_format($hours, 1); ?> h</strong>
            </td>
        </tr>
        <?php endforeach; ?>
        
        <tr>
            <td colspan="2" align="right" style="padding-top: 10px;">
                <strong style="color: #2c646c; font-size: 11px;">Total: <?php echo number_format($projectHours, 1); ?> h</strong>
            </td>
        </tr>
    </table>
    <?php endif; ?>

    <!-- Grand Total Section -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-top: 1px solid #ddd; margin-top: 30px; padding-top: 10px;">
        <tr>
            <td align="right">
                <h3 style="margin: 0; color: #2c646c; font-size: 14px;">Grand Total Hours Worked: <?php echo number_format($totalHours, 1); ?> hours</h3>
            </td>
        </tr>
    </table>
</body>
</html>

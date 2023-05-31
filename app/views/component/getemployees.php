<div id="component-employees">
    <table class="table table-bordered">
        <thead>
            <th>EID</th>
            <th>Last name</th>
            <th>First name</th>
            <th>Middle name</th>
            <th>Account status</th>
            <th>Gender</th>
            <th>Rate</th>
        </thead>

        <tbody>
            <?php foreach($employees as $emp): ?>
                <tr>
                    <td><?=$emp['emp_id'];?></td>
                    <td><?=$emp['last_name'];?></td>
                    <td><?=$emp['first_name'];?></td>
                    <td><?=$emp['middle_name'];?></td>
                    <td><?=$emp['status'];?></td>
                    <td><?=$emp['gender'];?></td>
                    <td><?=$emp['rate'];?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
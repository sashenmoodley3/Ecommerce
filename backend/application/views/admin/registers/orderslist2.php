<div class="material-datatables">
     <table id="datatables" class="table table-striped table-no-bordered table-hover custom-table" cellspacing="0" width="100%" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Wallet Transaction</th>
                <th class="text-center">Cr.</th>
                <th class="text-center">Dr.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Transaction Date</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Wallet Transaction</th>
                <th class="text-center">Cr.</th>
                <th class="text-center">Dr.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Transaction Date</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
//            var_dump($wallet_history);
//            $wallet_history = array();
            $count =1;
            foreach ($wallet_history as $history) {
                ?>
                <tr>
                    <td class="text-center"><?=$count++;?></td>
                    <td class="text-center"><?php echo !empty($history->transaction_by)?$history->transaction_by:''; ?></td>
                    <td class="text-center"><?php echo $history->cr_id; ?></td>
                    <td class="text-center"><?php echo $history->dr_id; ?></td>
                    <td class="text-center"><?php echo $history->description; ?></td>
                    <td class="text-center"><?php echo $history->created_date; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
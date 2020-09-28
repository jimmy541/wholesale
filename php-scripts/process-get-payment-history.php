<?php require($_SERVER['DOCUMENT_ROOT'].'/wholesale/include/connect.php'); 
		if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['customerid']) && !empty($_POST['customerid'])){ // condition 3
			$id = $_POST['id'];
			$customerid = $_POST['customerid'];
			
			$result = '';
			$result .= '<table class="row-border" id="paymentsTable">
			
				<thead>
					<tr>
						<th style="display:none;">ID</th>
						<th>Date</th>
						<th>Amount</th>
						<th>Method</th>
						<th>Ref. No.</th>
					</tr>
				</thead>
				<tbody>';
				
				
			$stmt = $link->prepare("SELECT `payment_id`, `pay_date`, `pay_amount`, `payment_method`, `reference_no` FROM `payments` WHERE `customer_hashed_id` = ? AND `clientid` = '$clientid' AND `invoice_hash` = ?");
			
			$stmt->bind_param('ss',$customerid, $id);
			$stmt->execute();
			$stmt->bind_result($pa_id, $pa_da, $pa_am, $pa_me, $re_no);
			
			while($stmt->fetch()){
				$result .= '<tr>';
				$result .= '<td style="display:none;" id="'.$pa_id.'">'.$pa_id.'</td>';
				$result .= '<td id="paydate'.$pa_id.'">'.date('m/d/Y', strtotime($pa_da)).'</td>';
				$result .= '<td id="payamount'.$pa_id.'">'.$pa_am.'</td>';
				$result .= '<td id="mop'.$pa_id.'">'.$pa_me.'</td>';
				$result .= '<td id="ref'.$pa_id.'">'.htmlspecialchars($re_no).'</td>';
		
				$result .= '</tr>';
			
			}
			$stmt->close();
			$result .= '</tbody></table>';
			echo $result;
			
		}
?>
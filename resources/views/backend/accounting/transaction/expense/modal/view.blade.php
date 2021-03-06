<div class="panel panel-default">
<div class="panel-body">
  <table class="table table-bordered">
	<tr><td>{{ _lang('Trans Date') }}</td><td>{{ date("d-M-Y", strtotime($transaction->trans_date) ) }}</td></tr>
	<tr><td>{{ _lang('Account') }}</td><td>{{ $transaction->account_name }}</td></tr>
	<tr><td>{{ _lang('Amount') }}</td><td>{{ $transaction->amount }}</td></tr>
	<tr><td>{{ _lang('Expense Type') }}</td><td>{{ $transaction->c_type }}</td></tr>
	<tr><td>{{ _lang('Payer') }}</td><td>{{ $transaction->payee_payer }}</td></tr>
	<tr><td>{{ _lang('Payment Method') }}</td><td>{{ $transaction->payment_method }}</td></tr>
	<tr><td>{{ _lang('Reference') }}</td><td>{{ $transaction->reference }}</td></tr>
	<tr>
	<td>{{ _lang('Attachment') }}</td>
		<td>
		  @if($transaction->attachment != "")
		   <a href="{{ asset('uploads/transactions/'.$transaction->attachment) }}" target="_blank" class="btn btn-primary">{{ _lang('View Attachment') }}</a>
		  @else
			  <label class="label label-warning">
		        <strong>{{ _lang('No Atachment Available !') }}</strong>
		      </label>
		  @endif
		</td>
	</tr>
	<tr><td>{{ _lang('Note') }}</td><td>{{ $transaction->note }}</td></tr>	
  </table>
</div>
</div>

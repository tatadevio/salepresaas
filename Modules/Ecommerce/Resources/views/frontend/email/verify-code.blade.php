<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="x-apple-disable-message-reformatting">
	<title></title>
	<!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
	<style>
		table,
		td,
		div,
		h1,
		p {
			font-family: Arial, sans-serif;
		}
	</style>
</head>

<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#70bbd9;">
							@if(isset($ecommerce_setting->logo))
							<img src="{{ url('frontend/images/') }}/{{$ecommerce_setting->logo}}" alt="{{$ecommerce_setting->site_title ?? ''}}" width="300" style="height:auto;display:block;">
							@else
							<img src="{{ asset('public/logo') }}/{{$general_setting->site_logo}}" alt="{{$ecommerce_setting->site_title ?? ''}}" width="300" style="height:auto;display:block;">
							@endif
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643;text-align:center">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello there!</h1>

										<p>Your verification code is - {{ $data['code'] }}</p><br><br>

										<p>Thank you</p>
										<p><strong>{{$ecommerce_setting->site_title ?? ''}}</strong></p>

									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>
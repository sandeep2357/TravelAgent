<font class="btitle">Booking Details</font>
<table cellpadding="2" cellspacing="2" width="100%">
<tr><td>Origin:{$booking.origin_name}</td></tr>
<tr><td>Destination:{$booking.destination_name}</td></tr>
<tr><td>Departure date: {$booking.user_booking_departure_date|date}</td></tr>
<tr><td>Returning date. {$booking.user_booking_arriving_date|date}</td></tr>
<tr><td>Airline: {$booking.airline_name}</td></tr>
<tr><td>Class: {$booking.class_name}</td></tr>
</table>
<font class="btitle">Passenger(s)</font>
<table width="100%">
<tr><td>
{section name=idx loop=$passenger}
{$passenger[idx].passenger_name}<br>
{/section}
</td></tr>
</table>
{if $found}
<table width="100%" cellpadding="2" cellspacing="2">
<tr><td>{$lang.found} {$found} Booking(s) .{$lang.displaying}: {$starting_no}-{$end_count} » Page {$currentpage}</td><td> {$page_link}</td></tr>
</table>

<table cellpadding="2" cellspacing="2" width="100%">
<tr><td class="btitle">{$lang.destination}</td><td class="btitle">Origin</td><td class="btitle">Departing Date</td><td class="btitle">Returning Date</td><td class="btitle">Passenger</td><td class="btitle">Details</td></tr>
{section name=idx loop=$booking}
<tr><td>{$booking[idx].origin_name}</td><td>{$booking[idx].destination_name}</td><td>{$booking[idx].user_booking_departure_date|date:"d/m/Y"}</td><td>{$booking[idx].user_booking_arriving_date|date}</td><td align="center">{$booking[idx].user_booking_total_passenger}</td><td><a href="index.php?m=member&op=bdetails&id={$booking[idx].user_booking_id}">show</a></tr>
{/section}
</table>

{else}

<table width="100%" cellpadding="2" cellspacing="2">
<tr><td>Sorry, there are no bookings</td><td> {$page_link}</td></tr>
</table>
{/if}
{config_load file=templates.ini section="common" scope="global"}

User {$data.billing.name} ({$data.login}) have exceeded minimum amount of discount points.
Amount of points (AUD): {$data.discount_point|money}
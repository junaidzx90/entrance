<?php global $current_user; ?>
<style>
 body{
    background: linear-gradient(1deg, #E22B6E, #FC6266) !important;
 }
 h1.entry-title {
    display: none;
}
</style>
<div id="orderspage">
    <h3 class="order_title">Order placed</h3>
    <?php
    $args = array(
        'customer_id' =>  $current_user->ID
    );
    $orders = wc_get_orders($args);
    foreach($orders as $order){
        $get_status = $order->get_status();
        $order_data = $order->get_data();

        foreach ( $order->get_items() as $item_id => $item ) {
            $product_id = $item->get_product_id();
            $product_name = $item->get_name();
        }
        
        ?>
        <div class="entcontainer">
            <h2><?php echo $product_name; ?></h2>
            <div class="detail">
                <p>Order Id: <?php echo $order_data['id']; ?></p>
                <p>Placed On: <?php echo date('d-m-y', strtotime($order->get_date_created())) ?></p>
            </div>
            <div class="prgrs_bar">
                <?php
                $activ = '';
                if($get_status == 'completed'){
                    $activ = 'activ';
                }
                ?>
                <div class="circle activ"></div>
                <div class="line"></div>
                <div class="circle <?php echo (($get_status == 'processing')?'activ':$activ) ?>"></div>
                <div class="line"></div>
                <div class="circle <?php echo $activ ?>"></div>
            </div>
            
            <div class="labels">
                <p class="hold">On Hold</p>
                <p class="process">Procesing</p>
                <p class="comp">Completed</p>
            </div>
        </div> 
        <?php
         $activ = '';
    }
    
    ?>
</div>
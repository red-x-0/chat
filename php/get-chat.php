<?php 
    session_start();
    if(isset($_COOKIE['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_COOKIE['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY date";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if ($row['msg_type'] === "text") {
                    if($row['outgoing_msg_id'] === $outgoing_id){
                        $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>'. $row['msg'] .'</p>
                                    </div>
                                    </div>';
                    }else{
                        $output .= '<div class="chat incoming">
                                    <img src="php/images/'.$row['img'].'" alt="">
                                    <div class="details">
                                        <p>'. $row['msg'] .'</p>
                                    </div>
                                    </div>';
                    }
                } else {
                    if($row['outgoing_msg_id'] === $outgoing_id){
                        $output .= '<div class="img outgoing">
                                        <div class="imgImg">
                                            <img src="msg/img/'.$row['msg'].'" alt="">
                                        </div>
                                    </div>';
                    }else{
                        $output .= '<div class="img incoming">
                                    <img src="php/images/'.$row['img'].'" alt="">
                                        <div class="imgImg">
                                            <img src="msg/img/'.$row['msg'].'" alt="">
                                        </div>
                                    </div>';
                    }
                }
                
            }
        }else{
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }

?>
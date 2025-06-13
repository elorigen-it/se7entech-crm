                                    <div style="overflow-x:auto;">
                                     <div class="row">
                                         <a href="export-data"><h4 class="btn btn-primary"><i class="fa fa-download"></i> Export</h4></a>
                                        <form method='post' action=''>
                                        <button type='submit' value='Delete' name='but_delete' class="btn btn-danger"><i class="fa fa-check"></i> Delete</button>
                                        <div class="card-header">
                                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                                        </div>
                                    
                                      <table class="table" id="myTable">
                                         <tr>
                                             <th>Check</th>
                                             <th>Client Name</th>
                                             <th>Email</th>
                                             <th>Phone</th>
                                             <th>Notes</th>
                                             <th>Date</th>
                                             <th style="<?=($access==0)?'':'display:none';?>">Assign To</th>
                                             <th>Action</th>
                                         </tr>
                                            
                                            <?php
                                            include('connection.php');
                                            $sql="select * from colleges $data  order by id desc";
                                            $result11=mysqli_query($con,$sql);
                                            
                                            
                                            if(mysqli_num_rows($result11))
                                            {
                                            
                                            $i=1;
                                            while($data=mysqli_fetch_assoc($result11))
                                            {
                                            ?>
                                     
                                             <tr>
                                             <td><input type='checkbox' name='delete[]' value='<?= $data['id'] ?>' ></form></td>
                                             <td><?= $data['client_name'];?></td>
                                             <td><?= $data['email'];?></td>
                                             <td><?= $data['phone'];?></td>
                                             <td><details><summary>View</summary><?= $data['name'];?></details> | <a target="blank" href="<?= $data['image'];?>">img</a> | <a target="blank" href="<?= $data['url'];?>" style="color:blue">Click</a> | <a target="blank" href="<?= $data['direction_link'];?>" style="color:blue" target="blank">Direction</a></td>
                                             <!--<td><details><summary>View</summary><? //= $data['address'];?></details></td>-->
                                              
                                             <td><?= date("d-m-Y", strtotime($data['date']));?></td>
                                             <td style="<?=($access==0)?'':'display:none';?>"><?= $data['logid'];?></td>
                                             <td style="<?=($access==0)?'':'display:none';?>">
                                                 <form method="POST"> 
                                              <input type="hidden" value="<?= $data['id'];?>" name="id">
                                              <select class="d" name="logid" style="width:150px">
                                                  <option value="#">--Agent--</option>
                                                 <?php
                                                    include('connection.php');
                                                    $sql="select * from invoice_user  order by id desc";
                                                    $result110=mysqli_query($con,$sql);
                                                    
                                                    if(mysqli_num_rows($result11))
                                                    {
                                                    
                                                     while($agent=mysqli_fetch_assoc($result110))
                                                    {
                                                    ?>
                                                 <option value="<?= $agent['email'];?>"><?php echo $agent['first_name'];?> <?php echo $agent['last_name'];?></option>
                                                 <?php }}?>
                                             </select>
                                             <button name="assignbtn" type="submit" class="btn btn-success">Assign</button>
                                              </form>
                                             </td>
                                             
                                             <td> <a target="blank" href="make-appointment?i=<?= $data['id'];?>" class="btn btn-dark">Appointment</a> <a title="Update info"  data-toggle="modal" data-target="#myModal<?= $data['id'];?>" class="btn btn-primary" href="#"><i class="fa fa-edit" style="color:white"></i></a></td>
                                        
                                         </tr>
                                    <div id="myModal<?= $data['id'];?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                    
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                     <h4 class="modal-title">Pinned Location</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h2>Update Clients Pin Information</h2>
                                     
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $data['id'];?>">
                                        <input type="hidden"  name="imgvalue" value="<?= $data['image'];?>">
                                        <div class="form-group"><input value="<?= $data['client_name'];?>" type="text" class="form-control" name="name" placeholder="Client's Name"></div>
                                        <div class="form-group"><input value="<?= $data['email'];?>" type="email" class="form-control" name="email" placeholder="Email"></div>
                                        <div class="form-group"><input value="<?= $data['phone'];?>" type="number" class="form-control" name="phone" placeholder="Phone"></div>
                                        <div class="form-group"><input value="<?= $data['url'];?>" type="url" class="form-control" name="url" placeholder="Url"></div>
                                        <div class="form-group"><input  type="file" accept="image/*" class="form-control" name="image" placeholder="image"></div>
                                        
                                        <div class="form-group"><div class="col-sm-12 scrolls" style="padding-top:10px">
                                        <audio id="myAudio">
                                        <source src="mixkit-video-game-mystery-alert-234.wav.ogg" type="audio/ogg">
                                        <source src="mixkit-video-game-mystery-alert-234.wav" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                        </audio>
                                       <!--<b>Choose Marker</b>-->
                                          <?php
                                        include('connection.php');
                                        $sql="select * from icons order by id desc";
                                        $result111=mysqli_query($con,$sql);
                                        
                                         if(mysqli_num_rows($result111))
                                        {
                                        
                                        while($rows11=mysqli_fetch_assoc($result111))
                                        {
                                        ?> 
                                            <input 
                                            type="radio" name="icon" 
                                            id="sad<?= $rows11['id'];?>" value="<?= $rows11['icon'];?>" class="input-hidden" />
                                            <label for="sad<?= $rows11['id'];?>">
                                            <img onclick="playAudio()" style="height:50px;width:48px;border-style:solid;border-width:1px;border-radius:3px;padding:7px;" src="images/<?= $rows11['icon'];?>">
                                             
                                            </label> 
                                        <?php }}?>
                                        </div>
                                        </div>
                                        <div class="form-group"><textarea  class="form-control" name="notes"><?= $data['name'];?></textarea></div>
                                        <button class="btn btn-default" type="submit" name="update">Update</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </form>
                                    </div>
                                     
                                    </div>
                                    
                                    </div>
                                    </div>
                                       <?php }}?>  
                                     </table>
                                      </div>    
                                    </div>
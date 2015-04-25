<section class="panel">
    <header class="panel-heading">
        prediction Details
    </header>
    <div class="panel-body">
        <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editpredictionsubmit");?>' enctype='multipart/form-data'>
            <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Prediction Group</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "predictiongroup",$predictiongroup,set_value( 'predictiongroup',$before->predictiongroup),"class='chzn-select form-control' disabled");?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Name</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="name" disabled value='<?php echo set_value(' name ',$before->name);?>'>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Status</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "status12",$status,set_value( 'status',$before->status),"class='chzn-select form-control' disabled");?>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Winner</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "predictionteam",$predictionteam,set_value( 'predictionteam',$before->predictionteam),"class='chzn-select form-control'");?>
                </div>
            </div>

                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Start Time</label>
                            <div class="col-sm-4">
                                <input type="datetime-local" id="normal-field" class="form-control" disabled name="starttime" value='<?php echo set_value(' starttime ',

$starttime);?>'>
                            </div>
                        </div>


            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">End Time</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="endtime" disabled value='<?php echo set_value(' endtime ',$before->endtime);?>'>
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Venue</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="venue" disabled value='<?php echo set_value(' venue ',$before->venue);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Order</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="order" disabled value='<?php echo set_value(' order ',$before->order);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Save</button>
<!--                    <a href='<?php echo site_url("site/viewpage"); ?>' class='btn btn-secondary'>Cancel</a>-->
                </div>
            </div>
        </form>
    </div>
</section>

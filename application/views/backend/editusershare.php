<section class="panel">
    <header class="panel-heading">
        usershare Details
    </header>
    <div class="panel-body">
        <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editusersharesubmit");?>' enctype='multipart/form-data'>
            <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">User</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "user",$user,set_value( 'user',$before->user),"class='chzn-select form-control'");?>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Share Content</label>
                <div class="col-sm-8">
                    <textarea name="sharecontent" id="" cols="20" rows="10" class="form-control"><?php echo set_value( 'sharecontent',$before->sharecontent);?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Total</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="total" value='<?php echo set_value(' total ',$before->total);?>'>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Prediction</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "prediction",$prediction,set_value( 'prediction',$before->prediction),"class='chzn-select form-control'");?>
                </div>
            </div>

            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Prediction Hash</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "predictionhash[]",$predictionhash,$selectedpredictionhash, "id='select2' class='chzn-select form-control' multiple");?>
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

<div class="container-fluid">
    <div class="jumbotron text-center"><h3>Get in touch! We're here for you...</h3></div>
    <div style="margin:40px 0">
        <div class="row">
            <div class="col-sm-5">
                <div class="panel-body panel">
                    <h4>Share Info With Us Via Email</h4>
                    <hr />
                    <form method="post" action="<?php print_link("info/contact"); ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" required id="name" name="name" placeholder="Your name *">
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" required id="email" name="email" placeholder="Your email *">
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" id="msg" name="msg" rows="4" required placeholder="Add comment..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>

            <div class="col-sm-7">
                <div class="panel panel-body">
                    <h4>Other Ways To Reach Us:</h4>
                    <hr />
                    <p>
                        <b class="chead"><i class="fa fa-map-marker"></i>Address</b><br />
                    <p class="adr clearfix">
                        <span class="adr-group">       
                            <span class="street-address">No 9 Rossini Street, Windhoek West</span><br>
                            <span class="postal-code">P.O. Box 8925 Bachbrecht</span><br>
                            <span class="country-name">Windhoek, Namibia</span>
                        </span>
                    </p>
                    </p>
                    <hr />
                    <p>
                        <b class="chead"><span class="fa fa-phone"></span> Phone</b><br />
                        <span class="editContent"> +264 61 252 377</span>
                    </p>
                    <hr />

                    <p>
                        <b class="chead"><span class="fa fa-email"></span> Email</b><br />
                        <a href="#" class="editContent">support@imarketing.com.na</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
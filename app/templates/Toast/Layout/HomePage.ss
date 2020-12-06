<section class="home-hero-section">
    <div class="mx-auto max-w-xl">
        <div class="relative cta">

            <p class="header">$Hero_Header</p>
            $Hero_Text
        </div>
        <button>Learn More</button>
        <figure class="home-hero-img-2 absolute w-8/12"
                style="background-image: url('images/hero4.png')"></figure>

    </div>
</section>

<section class="clearfix">
    <div class="flex">
        <% if $Section1_Image %>
            <img class="w-7/12" src="$Section1_Image.URL"/>
        <% end_if %>



        <div class="w-5/12  lg:float-right px-10 pt-20 ">

            <div class="cta">
                <p class="header">$Section1_Heading</p>
                $Section1_Text
            </div>
            $Section1_Copy

        </div>


    </div>
</section>

<section class="clearfix">
    <div class="mx-auto max-w-xl flex items-center justify-between">
        <div class="w-5/12 float-left  pr-8">
            <div class="cta">
            <p class="header">$Section2_Heading</p>
                $Section2_Text
            </div>
            $Section2_Copy

        </div>
        <% if $Section2_Image %>
        <img class="w-7/12 float-right" src="$Section2_Image.URL"/>
        <% end_if %>
    </div>
</section>


<section class="clearfix">
    <div class="mx-auto max-w-xl flex items-center justify-between">
        <div class="w-6/12 cta">

            $Section3_Text

        </div>

        <div class="w-6/12 float-right">
            $Section3_Copy
           <%-- <form>
                $Section3_Copy
                <div class="form-field w-6/12 float-left md:pr-2"><input type="text" placeholder="Name"></div>
                <div class="form-field w-6/12 float-right"><input type="text" placeholder="Email"></div>
                <div class="form-field w-full"><input type="text" placeholder="Company"></div>

                <button>Submit</button>

            </form>--%>

            $ContactForm

        </div>
    </div>
</section>

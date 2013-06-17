
<html>

<head>
	<title>Dynamic inheritance because YOLO</title>

	<style type="text/css">
		li{
			margin-bottom: 20px;
			margin-top: 20px;
		}
	</style>
</head>


<body>


<h1>Dynamic inheritance in PHP</h1>


<h2>The problem</h2>


<div style='max-width: 1024px'>
<img src='images/ProblemToSolve.png' style='float: right;'/>

<p>
	Very, very, occasionally it would be very useful to be able to use dynamic inheritance. The problem I encountered that led me to investigate dynamic inheritance was that that on my website I wanted to be able to:

	<ul>
		<li>Define how the contents of a page are rendered in one template file. e.g. if you go to view a page of images, a template defines the html for how the images are rendered.</li>

		<li>Be able to wrap each of those content template with the appropriate surrounding chunks of infrastructure for viewing etiher the page or Ajax request with another template. i.e. PageTemplate or AjaxTemplate in the diagrams to the right.</li>

		<li>
			Be able to swap the surrounding template at runtime e.g. If the request for the images was made to a new page, then the content needs to be surrounded by the template that defines a full HTML page with .<br/>
			If it was an Ajax request to just get the next set of images, to swap out the current set of images, then the content would just need to be wrapped by the appropriate JSONP code.
		</li>

		<li>
			Be able to do the above without having to either define interfaces that the components would use, or having to put together a whole load of dependencies framework.
		</li>
	</ul>
</p>

	<p>This <a href='TheProblem.php'>is a demo of that problem</a> where Ajax calls to refresh the images on a page actually embed a new copy of the page inside the original page. Which is not what's wanted.</p>

</div>


<div style='clear: both'></div>

<h2>Disclaimer</h2>

<p>
	You <b>really</b> ought to think at least twice before using this technique as it's actually kind of bad thing to do.</p>

<p>	For the record the only reason I'm using this technique is because I don't want to have to either create the interface definitions or setup the dependency injections when creating templates for a site. I want to just be able to just define a couple of function 'blocks' in a template and then have inheritance automatically use the correct 'block'.
</p>




<h2>A solution - dynamic inheritance</h2>

<div style='max-width: 1600px'>

<img src='images/DynamicInheritance.png' style='float: right;'/>

<p>

It is possible to create dynamic inheritance in PHP using the power of the magic <a href='http://www.php.net/manual/en/language.oop5.overloading.php#object.call'>__call function</a>. It takes a little bit of infrastructure code to work but isn't too daunting.</p>

<p>The steps required are:


<ul>
	<li>
		The child class now extends a 'DynamicExtender' class. This class intercepts any calls made by the child class, to methods that don't exist in the child class and redirects them to the parent instance.
	</li>

	<li>
		Each 'ParentClass' is extended to a 'ProxyParentClass'. For every accessible method in the parent class, there exists an equivalent method in the 'ProxyParentClass'. Each of those methods in the 'ProxyParentClass' checks to see if the method exists in the ChildClass and calls the childs version of the function if it exists, otherwise it calls the version from  ParentClass
	</li>

	<li>
		When the DynamicExtender class is constructed you pass in what parent class you require, the DynamicExtender creates a new instance of that class, and sets itself as the child of the ParentClass.
	</li>
</ul>

</p>

<p>
	So, now when we create the Images object we can specify the parent class required and the DynamicExtender will create it for us, and it will appear as if the Images class is extended from the class we requested at run-time rather than it being hard-coded.
</p>

<p>
	To be honest, the code in 'TheSolution.php' may be easier to follow than the description above. It even has comments and everything.
</p>

<a href='TheSolution.php'>Demo of dynamic inheritance working</a>

</div>
<div style='clear: both'></div>


<h2>Notes</h2>

<ul>

	<li>Proxying the parent classes by hand is probably a bad idea. You should either only be using this when you're auto-genering code, and so can add the Proxied versions of the classes when you generate the code. Or you should use a tool like
		<a href='https://github.com/ejsmont-artur/phpProxyBuilder'>PHP Proxy Builder to dynamically proxy your classes.</a>
	</li>

	<li>
		Because this code uses 'call_user_func_array' it will be slower than static inheritance. However so long as you're only making a few function calls per request this shouldn't be a noticeable issue.
	</li>
<li>I didn't implement anything to support accessing the properties of the parent class dynamically. That's not an oversight - it would just be a really bad idea to implement that.
</li>

</ul>


<h2>How and why I'm using dynamic inheritance</h2>

<p>
	Up until very recently I've been using Smarty for creating template to render content on my website. Although it has been great and has served me well for a couple of years it doesn't support dynamic inheritance in it's templates, which has been annoying me for a bit as it meant I had to have great big if/elseif blocks in my templates to handle whether a request was being made for a full page (i.e. content surrounded by a html + body tags), or whether it was an Ajax request where only the actual content was required.
</p>

<p>
So I hacked around and wrote a replacement for Smarty. My template for rendering a page (or panel, if requested by Ajax) of images still looks very much like a <a href='http://www.smarty.net/docs/en/advanced.features.template.inheritance.tpl' target='_blank'>Smarty template using extend</a>:

<pre>
{dynamicExtends file='standardContent'}

{block name='toolPanel'}
	&lt;!-- tool panel is disabled --&gt;
{/block}

{block name='mainContent'}
	{foreach $imageArray as $image}
	    {$image->displayThumbnail() | nofilter}
	{/foreach}

	&lt;?php $this->view->addBodyLoadFunction("initContent({
		contentSelector: '.content',
		isPreview: true
	});") ?&gt;

{/block}
</pre>

That template gets converted to a PHP class called 'Images' with each of the blocks defining a function that can be called by the parent class, to use instead of the placeholder block.</p>

<p>
Just like Smarty blocks can be defined in the parent or child template file and the appropriate function block will be used, based on the standard rules of class inheritance.
</p>
<p>
At run time 'standardContent' gets replaced either with 'standardContentPage' or 'standardContentAjax' and the appropriate class is used as the parent class. So it all works magically without nasty if/else blocks all over the place.
</p>

<p>
	Although I could handle this without using Dynamic Inheritance and instead using either dependency injection or other methods, they would not, imho, be as either as simple or flexible as using dynamic inheritance, as it would requiring interface definitions for all of the functionality that might need to be swapped around. </p>

<p>With the dynamic inheritance I can just define the blocks in the parent and child classes and the functionality will be composited together without the need for any wiring up of things to be injected.

	<br/>&nbsp;<br/>

	cheers<br/>
	<a href='http://blog.basereality.com'>Danack</a>
</p>

</body>

</html>
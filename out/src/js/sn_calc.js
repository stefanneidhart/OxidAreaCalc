
var CalcHandler = function (CalcTypes)
{
    this.jsonrawdata = CalcTypes;
    this.typedataarr = [];
    this.currentTypeID = '';
    this.currentType = [];
    this.option1 = '';
    this.option1active = false;
    this.option2 = '';
    this.option2active = false;

    this.init = function ()
    {
	var myself = this;

	var jsonOBJ = $.parseJSON(this.jsonrawdata);

	//  alert(this.jsonrawdata);

	$.each(jsonOBJ, function (index, typeitem) {
	    myself.typedataarr[typeitem['OXID']] = typeitem;
	});

	$('#hoehe, #breite').change(function () {
	    myself.setMinH();
	    myself.setMaxH();
	    myself.calcArea();
	    myself.calcPrice();
	    alert('hb');
	});


	$('#areacalc_opt1').change(function () {
	    if ($(this).prop("checked")) {
		myself.option1active = true;
	    } else {
		myself.option1active = false;
	    }
	    myself.calcPrice();
	});

	$('#areacalc_opt2').change(function () {
	    if ($(this).prop("checked")) {
		myself.option2active = true;
	    } else {
		myself.option2active = false;
	    }
	    myself.calcPrice();
	});


	$('#MaterialTypesSelect').change(function (event) {


	    var optionSelected = $(this).children('option:selected');
	    var valueSelected = optionSelected.attr('value');
	    var textSelected = optionSelected.text();



	    myself.currentTypeID = valueSelected;
	    myself.currentType = myself.typedataarr[valueSelected];



	    myself.setMinH();
	    myself.calcArea();
	    myself.calcPrice();


	});
	$('#MaterialTypesSelect').change();
    }

    this.calcArea = function ()
    {

	var hoehe = this.getHeight();
	var breite = Number($('#breite').val());


	var result = hoehe * breite;
	$('#AreaResult').html(result + ' m²');
	this.calcWeight(result);
    }

    this.setMinH = function () {
	if (this.getHeight() < Number(this.currentType['hoehe_min'])) {
	    $('#hoehe').val(Number(this.currentType['hoehe_min']));
	}
    }

    this.setMaxH = function () {
	if (this.getHeight() > Number(this.currentType['hoehe_max'])) {
	    $('#hoehe').val(Number(this.currentType['hoehe_max']));
	}
    }

    this.calcWeight = function (area) {
	var weight = (area * this.currentType['gewicht']) / 1000;
	//$('.WeightContainer .WeightResult').html(weight + ' KG');
	$('.weight').html('Gewicht: '+ weight + ' kg');
    }

    this.getHeight = function () {
	var tempHeight = $('#hoehe').val();
	tempHeight = tempHeight.replace(",", ".");
	return parseFloat(tempHeight);
    }

    this.getWidth = function () {
	var tempWidth = $('#breite').val();
	tempWidth = tempWidth.replace(",", ".");
	return parseFloat(tempWidth);
    }

    this.setPrice = function (price) {
	$('#productPrice').html('<span><span class="price-from"></span><span class="price">' + price + ' €</span><span class="price-markup">*</span><span class="d-none"> <span itemprop="price">' + price + ' €</span></span></span>');
    }

    this.setUnitPrice = function (price) {
	$('#productPriceUnit').html(price + ' € je m²');
    }

    this.calcPrice = function ()
    {
	alert('calc1');
	var myself = this;
	var hoehe = this.getHeight();
	var breite = this.getWidth();
	
	var anzahlStaffeln = myself.currentType['staffeln'].length;
	
	var staffelung = myself.currentType['staffeln'][0];
	alert('calc2 Anzahl Staffeln: ' + anzahlStaffeln);
	for (var i = 0; i < anzahlStaffeln; i++) {
	    var staffel_max_h = this.currentType['staffeln'][i]['staffel'];
	    if (hoehe > staffel_max_h) {
		if (i + 1 >= anzahlStaffeln ) {
		    staffelung = myself.currentType['staffeln'][i];
		} else {
		    staffelung = myself.currentType['staffeln'][i + 1];
		}
	    }
	}
	
	alert('Grösste Staffel: ' + this.currentType['staffeln'][anzahlStaffeln-1]['staffel']);
	
	alert('calc3');
	var baseprice_staffel = Number(staffelung['preis']);

	if (this.option2active === true) {
	    baseprice_staffel = baseprice_staffel + (Number(this.option2));
	}
alert('calc4');
	var newPrice = (breite * hoehe) * baseprice_staffel;

	if (this.option1active === true) {
	    newPrice = newPrice + (Number(this.option1) * breite);
	}
alert('calc5'+newPrice);
	this.setPrice(newPrice);
	//this.setUnitPrice(newPrice/(breite * hoehe));
	
	alert('calcx');
    }

    this.setOption1 = function (option) {
	this.option1 = option;
    }

    this.setOption2 = function (option) {
	this.option2 = option;
    }
};

$(document).ready(function ()
{

    var CH = new CalcHandler(typejsonraw);
    CH.init();
    CH.setOption1(option1);
    CH.setOption2(option2);
});

/*! Validatr - v0.5.1 - 2013-03-12
 * http://jaymorrow.github.com/validatr/
 * Copyright (c) 2013 Jay Morrow; Licensed MIT */
(function (t, e, a, r) {
    "use strict";
    function i(t, e) {
        if (this.el = t, this.$el = a(t), !this.$el.length || !this.$el.is("form"))throw Error("validatr needs a form to work.");
        this.isSubmit = !1, this.firstError = !1, this.options = a.extend({}, a.fn.validatr.defaultOptions, e), this.template = function (t) {
            var e = a(t.template).addClass("validatr-message");
            return t.theme.length ? e.addClass(w[t.theme] || t.theme) : e.css(k), e[0].outerHTML
        }(this.options), this.option = function (t, e) {
            return arguments.length ? e === r ? this.options[t] === r ? null : this.options[t] : (this.options[t] = e, r) : a.extend({}, this.options)
        }, this.formElements = this.getElements(this.el).on("valid.validatr", a.proxy(f, this)).on("invalid.validatr", a.proxy(c, this)), this.el.noValidate = !0, this.$el.on("submit.validatr", a.proxy(m, this)), this.$el.on("reset.validatr", a.proxy(p, this))
    }

    function s() {
        this.formElements.on({
            "focus.validatrelement": o,
            "blur.validatrelement": l
        }), a("input[type=radio], input[type=checkbox]").on("click.validatrelement", function (t) {
            u(t.target)
        })
    }

    function n() {
        this.formElements.off(".validatrelement")
    }

    function o(t) {
        var e = t.target, r = a(e);
        "select" === e.nodeName.toLowerCase() && r.on("change.validatrinput", function () {
            setTimeout(function () {
                u(e)
            }, 1)
        }), r.on({
            "blur.validatrinput": function () {
                u(e)
            }, "keyup.validatrinput": function (t) {
                e.value.length && -1 === a.inArray(E, t.keyCode) && u(e)
            }
        })
    }

    function l(t) {
        a(t.target).off(".validatrinput")
    }

    function u(t) {
        if ("radio" === t.type) {
            var r = a(e.getElementsByName(t.name)).filter("[required]");
            r.length && (t = r[0])
        }
        var i = a(t), s = x.notInput.test(t.nodeName) ? t.nodeName.toLowerCase() : t.getAttribute("type"), n = v.attributes.required ? t.required : a(t).is("[required]"), o = {
            valid: !0,
            message: ""
        };
        if (v.inputtypes[s] ? (o.valid = t.validity.valid, o.message = t.validationMessage) : (n && (o = y.required(t)), o.valid && t.value.length && !x.boxes.test(s) && (t.pattern && (s = "pattern"), y[s] && (o = y[s](t)))), o.valid)for (var l in b)if (b.hasOwnProperty(l) && i.is("[data-" + l + "]") && (o = b[l](t), !o.valid))break;
        return o.valid ? (i.trigger("valid"), !0) : (a.data(t, "validationMessage", o.message), i.trigger("invalid"), !1)
    }

    function d(t) {
        var e = !0;
        return t.each(function (t, a) {
            u(a) || (e = !1)
        }), e
    }

    function m() {
        this.isSubmit = !0, p.call(this);
        var t = d(this.formElements);
        return t ? this.options.valid.call(this.el, this.el) : (s.call(this), this.isSubmit = !1, t)
    }

    function p() {
        n.call(this), this.firstError = !1, this.formElements.next(".validatr-message").remove()
    }

    function c(t) {
        if (!A) {
            t.preventDefault();
            var e = t.target, i = a(e), s = this.options, n = e.getAttribute("data-message") || a.data(e, "validationMessage"), o = a(this.template.replace("{{message}}", n));
            return this.isSubmit && !this.firstError ? (this.firstError = i.after(o), s.position.call(this, o, i), r) : ((!this.isSubmit || s.showall) && (f(t), i.after(o), s.position.call(this, o, i)), r)
        }
    }

    function f(t) {
        A || a(t.target).next(".validatr-message").remove()
    }

    function h(t, e) {
        t.css("position", "absolute");
        var a = e.offset(), r = e[0].getAttribute("data-location") || this.options.location;
        x.topbottom.test(r) ? (t.offset({left: a.left}), "top" === r && t.offset({top: a.top - t.outerHeight() - 2}), "bottom" === r && t.offset({top: a.top + t.outerHeight()})) : x.leftright.test(r) && (t.offset({top: a.top + e.outerHeight() / 2 - t.outerHeight() / 2}), "left" === r && t.offset({left: a.left - t.outerWidth() - 2}), "right" === r && t.offset({left: a.left + e.outerWidth() + 2}))
    }

    var v = function () {
        var t, a = {}, i = e.documentElement, s = e.createElement("input"), n = e.createElement("select"), o = e.createElement("textarea"), l = ":)", u = {}, d = {};
        return a.attributes = function (t) {
            for (var e = 0, a = t.length; a > e; e++)d[t[e]] = !!(t[e] in s);
            return d
        }("max min multiple pattern required step".split(" ")), a.inputtypes = function (t) {
            for (var a, n, o, d = 0, m = t.length; m > d; d++)s.setAttribute("type", n = t[d]), a = "text" !== s.type, a && (s.value = l, s.style.cssText = "position:absolute;visibility:hidden;", /^range$/.test(n) && s.style.WebkitAppearance !== r ? (i.appendChild(s), o = e.defaultView, a = o.getComputedStyle && "textfield" !== o.getComputedStyle(s, null).WebkitAppearance && 0 !== s.offsetHeight, i.removeChild(s)) : /^(search|tel)$/.test(n) || (a = /^(url|email)$/.test(n) ? s.checkValidity && s.checkValidity() === !1 : s.value !== l)), u[t[d]] = !!a;
            return u
        }("search tel url email datetime date month week time datetime-local number range color".split(" ")), function (r) {
            for (var i = 0, n = r.length; n > i; i++) {
                t = s;
                try {
                    t.setAttribute("type", r[i])
                } catch (o) {
                    t = e.createElement('<input type="' + r[i] + '">')
                }
                t.style.cssText = "position:absolute;visibility:hidden;", a.inputtypes[r[i]] = !!t.checkValidity
            }
        }("text password radio checkbox".split(" ")), a.inputtypes.select = !!n.checkValidity, a.inputtypes.textarea = !!o.checkValidity, s = null, t = null, n = null, o = null, a
    }(), g = function () {
        function t(t, e) {
            for (var a = -1, r = t ? t.length : 0; r > ++a;)if (t[a] === e)return a;
            return -1
        }

        function e(e) {
            var i = e.getAttribute("data-format") || a.fn.validatr.defaultOptions.dateFormat, s = i.split(n.separatorsNoGroup), o = e.value.split(n.separatorsNoGroup), l = "yyyy-mm-dd".split("-"), u = i.replace(n.separators, "\\$1").replace("yyyy", n.dateParts.yyyy).replace("mm", n.dateParts.mm).replace("dd", n.dateParts.dd), d = -1, m = l.length, p = [];
            if (u = RegExp(u), !u.test(e.value))return !1;
            for (; m > ++d;)p[d] = o[t(s, l[d])];
            return r(p.join("-"))
        }

        function r(t) {
            if (!s.isoDate.test(t))return !1;
            var e = s.isoDate.exec(t);
            return new Date(parseInt(e[1], 10), parseInt(e[2], 10) - 1, parseInt(e[3], 10))
        }

        function i(t, e) {
            function r(t) {
                return 10 > t ? "0" + t : t
            }

            var i = r(t.getDate()), s = r(t.getMonth() + 1), n = t.getFullYear(), o = (e.getAttribute("data-format") || a.fn.validatr.defaultOptions.dateFormat).replace("mm", s).replace("yyyy", n).replace("dd", i);
            return o
        }

        var s = {isoDate: /^(\d{4})-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/}, n = {
            separators: /(\/|\-|\.)/g,
            separatorsNoGroup: /\/|\-|\./g,
            dateParts: {dd: "(0[1-9]|[12][0-9]|3[01])", mm: "(0[1-9]|1[012])", yyyy: "(\\d{4})"}
        };
        return {formatISODate: i, parseDate: e, parseISODate: r}
    }(), y = function () {
        var t = {
            color: /^#[0-9A-F]{6}$/i,
            email: /^[a-zA-Z0-9.!#$%&’*+\/=?\^_`{|}~\-]+@[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)*$/,
            isoDate: /^(\d{4})-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/,
            number: /^-?\d*\.?\d*$/,
            time: /^([01][0-9]|2[0-3])(:([0-5][0-9])){2}$/,
            url: /^\s*https?:\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?\s*$/
        }, i = {boxes: /checkbox|radio/i, spaces: /,\s*/}, s = function (t, e, r, i, s) {
            var n = !0, o = a.validatr.messages.range.base, l = e, u = r;
            return "date" === s && (l = e && g.formatISODate(e, this), u = r && g.formatISODate(r, this)), t !== !1 && (i !== !1 && (n = "any" === i ? !0 : 0 === (t - e) % i, o = a.validatr.messages.range.invalid), n && (e !== !1 && r !== !1 ? (n = t >= e && r >= t, o = a.validatr.messages.range.overUnder) : e !== !1 ? (n = t >= e, o = a.validatr.messages.range.overflow) : r !== !1 && (n = r >= t, o = a.validatr.messages.range.underflow))), {
                valid: t !== !1 && n,
                message: o.replace("{{type}}", s).replace("{{min}}", l).replace("{{max}}", u)
            }
        };
        return {
            checkbox: function (t) {
                return {valid: t.checked, message: a.validatr.messages.checkbox}
            }, color: function (e) {
                return {valid: t.color.test(e.value), message: a.validatr.messages.color}
            }, date: function (t) {
                var e = a(t), r = v.inputtypes.date ? g.parseISODate(t.value) : g.parseDate(t), i = e.attr("min") ? g.parseISODate(e.attr("min")) : !1, n = e.attr("max") ? g.parseISODate(e.attr("max")) : !1, o = !1;
                return s.call(t, r, i, n, o, "date")
            }, email: function (e) {
                var s = !0, n = a.validatr.messages.email.single, o = v.attributes.multiple ? e.multiple : a(e).is("[multiple]");
                if (o) {
                    var l = e.value.split(i.spaces);
                    a.each(l, function (e, i) {
                        return t.email.test(i) ? r : (s = !1, n = a.validatr.messages.email.multiple, r)
                    })
                } else s = t.email.test(e.value);
                return {valid: s, message: n}
            }, number: function (e) {
                var a = e.value.replace(",", ""), r = (t.number.test(a) ? parseFloat(a) : !1, t.number.test(e.getAttribute("min")) ? parseFloat(e.getAttribute("min")) : !1), i = t.number.test(e.getAttribute("max")) ? parseFloat(e.getAttribute("max")) : !1, n = t.number.test(e.getAttribute("step")) ? parseFloat(e.getAttribute("step")) : "any" === e.getAttribute("step") ? "any" : !1;
                return (n === !1 || 0 >= n) && (n = 1), s.call(e, a, r, i, n, "number")
            }, pattern: function (t) {
                return {valid: RegExp(t.getAttribute("pattern")).test(t.value), message: a.validatr.messages.pattern}
            }, radio: function (t) {
                return {valid: a(e.getElementsByName(t.name)).is(":checked"), message: a.validatr.messages.radio}
            }, range: function (t) {
                return this.number(t)
            }, required: function (t) {
                return i.boxes.test(t.type) ? this[t.type](t) : {
                    valid: !!t.value.length,
                    message: "select" === t.nodeName.toLowerCase() ? a.validatr.messages.select : a.validatr.messages.required
                }
            }, time: function (e) {
                return {valid: t.time.test(e.value), message: a.validatr.messages.time}
            }, url: function (e) {
                return {valid: t.url.test(e.value), message: a.validatr.messages.url}
            }
        }
    }(), b = function () {
        function t(t) {
            if ("text" !== t.type)throw Error("element must have a type of text");
            var e = t.getAttribute("data-as");
            return y[e] ? y[e](t) : r
        }

        function i(t) {
            var r = t.getAttribute("data-match"), i = e.getElementById(r) || e.getElementsByName(r)[0];
            return i ? (a(i).off("valid.validatrinput").on("valid.validatrinput", function () {
                t.value === i.value && u(t)
            }), {valid: t.value === i.value, message: "'" + t.name + "' does not equal '" + i.name + "'"}) : {
                valid: !1,
                message: "'" + r + "' can not be found"
            }
        }

        return {as: t, match: i}
    }(), x = {
        boxes: /checkbox|radio/i,
        leftright: /left|right/i,
        notInput: /select|textarea/i,
        topbottom: /top|bottom/i
    }, E = [16, 17, 18, 19, 20, 33, 34, 35, 36, 37, 39], w = {
        bootstrap: "alert alert-error",
        jqueryui: "ui-state-error ui-corner-all"
    }, k = {
        color: "#f0444d",
        backgroundColor: "#ffcbcb",
        border: "1px solid #e4a6af",
        padding: "2px 6px",
        borderRadius: "2px"
    }, A = !1, q = function () {
    };
    q.prototype = {
        addTest: function (t) {
            var e = "string" != typeof t, r = Array.prototype.slice.call(arguments, 1)[0];
            if (e)a.extend(b, t); else {
                if (!r)throw Error("You must include a callback function");
                b[t] = r
            }
        }, getElements: function (t) {
            if (this.formElements)return this.formElements;
            var e = a(t).map(function () {
                return a.makeArray(this.elements)
            }).not("fieldset, button, input[type=submit], input[type=button], input[type=reset]");
            return t.id && (e = e.add(a('[form="' + t.id + '"]'))), e
        }, validateElement: function (t) {
            if (!t)throw Error("method requires an element");
            A = !0;
            var e = u(t[0] || t);
            return A = !1, e
        }, validateForm: function (t) {
            var e, a = this.el || (t instanceof jQuery ? t[0] : t);
            if ("form" !== a.nodeName.toLowerCase())throw Error("you must pass a form to this method");
            return A = !0, e = d(this.formElements || this.getElements(a)), A = !1, e
        }
    }, a.fn.validatr = function (t) {
        var e, s = "string" == typeof t, n = Array.prototype.slice.call(arguments, 1), o = this;
        if (s)this.each(function () {
            var i;
            if (e = a.data(this, "validatr"), !e)throw Error("cannot call methods on validatr prior to initialization; attempted to call method '" + t + "'");
            if (!a.isFunction(e[t]))throw Error("no such method '" + t + "' for validatr instance");
            return i = e[t].apply(e, n), i !== e && i !== r ? (o = i && i.jquery ? o.pushStack(i.get()) : i, !1) : r
        }); else {
            var l;
            this.each(function () {
                e = a.data(this, "validatr"), e || (l = new q, i.call(l, this, t || {}), a.data(this, "validatr", l))
            })
        }
        return o
    }, a.fn.validatr.defaultOptions = {
        dateFormat: "yyyy-mm-dd",
        location: "right",
        position: h,
        showall: !1,
        template: "<div>{{message}}</div>",
        theme: "",
        valid: a.noop
    }, a.validatr = new q, a.validatr.messages = {
        checkbox: "Please check this box if you want to proceed.",
        color: "Please enter a color in the format #xxxxxx",
        email: {
            single: "Please enter an email address.",
            multiple: "Please enter a comma separated list of email addresses."
        },
        pattern: "Please match the requested format.",
        radio: "Please select one of these options.",
        range: {
            base: "Please enter a {{type}}",
            overflow: "Please enter a {{type}} greater than or equal to {{min}}.",
            overUnder: "Please enter a {{type}} greater than or equal to {{min}}<br> and less than or equal to {{max}}.",
            invalid: "Invalid {{type}}",
            underflow: "Please enter a {{type}} less than or equal to {{max}}."
        },
        required: "Please fill out this field.",
        select: "Please select an item in the list.",
        time: "Please enter a time in the format hh:mm:ss",
        url: "Please enter a url."
    }, a.validatr.debug = function () {
        if (!QUnit)throw Error("QUnit is required for debugging");
        this.Support = v, this.Tests = y, this.CustomTests = b, this.Format = g
    }, a.expr[":"].validatr = function (t) {
        return !!a.data(t, "validatr")
    }
})(this, this.document, jQuery);
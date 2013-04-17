IK("editable-select", "datePicker", "validate", function() {
	function d(j, f, o, g) {
		var h = f || "", k = j || "", n = o || "", l = g || "", p = '<select id="' + h + '" name="' + h + '"class="basic-input editable-select ' + n + '" style="width:110px;">';
		p += '<option value="' + ( l ? "开始" : "结束") + '时间"' + ( k ? "" : "selected") + ">" + ( l ? "开始" : "结束") + "时间</option>";
		for(var m = 8; m < 24; m++) {
			var e = [];
			e.push(m < 10 ? "0" + m + ":00" : m + ":00");
			e.push(m < 10 ? "0" + m + ":30" : m + ":30");
			for(hhmm in e) {
				if(e[hhmm] == k) {
					p += '<option value="' + e[hhmm] + '" selected>' + e[hhmm] + "</option>"
				} else {
					p += '<option value="' + e[hhmm] + '">' + e[hhmm] + "</option>"
				}
			}
		}
		for(var m = 0; m < 8; m++) {
			var e = [];
			e.push("0" + m + ":00");
			e.push("0" + m + ":30");
			for(hhmm in e) {
				if(e[hhmm] == k) {
					p += '<option value="' + e[hhmm] + '" selected>' + e[hhmm] + "</option>"
				} else {
					p += '<option value="' + e[hhmm] + '">' + e[hhmm] + "</option>"
				}
			}
		}
		p += "</select>";
		return p
	}

	function a(i) {
		i.preventDefault();
		var h = $("#eventDateIntermHook .interm-item").length;
		if(h > 49) {
			return false
		} else {
			if(h == 49) {
				$("#addEventDaysHook").parent().hide()
			}
		}
		var f = '<div class="inner-item interm-item hide"><input class="basic-input event_calendar interm_day" type="text" size="12"> <input type="hidden" class="editableHook" data-class="intermBeginTime" data-start="true"/> 至&nbsp;&nbsp; <input type="hidden" class="editableHook" data-class="intermEndTime"/> <a href="javascript:void(0);" class="btn-cancel">×</a></div>', g = $("#addEventDaysHook").parent();
		if(lowLevelBrowser) {
			$(f).insertBefore(g).show()
		} else {
			$(f).insertBefore(g).slideDown("fast")
		}
		c(g.parent())
	}

	function c(e) {
		e.find(".editableHook").each(function() {
			var j = $(this), i = j.attr("data-time") || "", l = j.attr("data-id") || "", g = j.attr("data-class") || "", k = j.attr("data-start") || "", f = "";
			if(!j.data("beenInited")) {
				f = d(i, l, g, k);
				var h = $(f).insertBefore(j);
				h.editableSelect({
					bg_iframe : true,
					item_then_scroll : 20
				});
				h.removeClass("intermBeginTime intermEndTime");
				j.prev().trigger("blur");
				j.data("beenInited", true)
			}
		});
		e.find(".event_calendar").each(function() {
			var f = $(this);
			if(!f.data("beenCalendared")) {
				f.datepicker({
					dateFormat : "yy-mm-dd",
					dayNamesMin : ["日", "一", "二", "三", "四", "五", "六"],
					monthNames : ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
					minDate : new Date(),
					prevText : "<<",
					nextText : ">>"
				});
				f.data("beenCalendared", true)
			}
		})
	}

	function b() {
		var o = $("#repeat_type").val(), i = [], f = [], l = '<div class="inner-item">';
		switch(o) {
			case"1":
				l += $("#more_begin_day").val();
				l += " 至 ";
				l += $("#more_end_day").val();
				l += " 每天 ";
				l += $("#more_begin_time").val().match("时间") ? "" : $("#more_begin_time").val();
				l += " 至 ";
				l += $("#more_end_time").val().match("时间") ? "" : $("#more_end_time").val();
				l += "</div>";
				if($("#more_begin_day").val()) {
					$("#eventContinueDescHook").html(l)
				}
				break;
			case"2":
				$("#week_mon").attr("checked") && (i.push("一"), f.push(1));
				$("#week_tue").attr("checked") && (i.push("二"), f.push(2));
				$("#week_wed").attr("checked") && (i.push("三"), f.push(3));
				$("#week_thu").attr("checked") && (i.push("四"), f.push(4));
				$("#week_fri").attr("checked") && (i.push("五"), f.push(5));
				$("#week_sat").attr("checked") && (i.push("六"), f.push(6));
				$("#week_sun").attr("checked") && (i.push("日"), f.push(7));
				l += $("#week_begin_day").val();
				l += " 至 ";
				l += $("#week_end_day").val();
				l += " 每" + (i.length == 7 ? "天" : "周" + i.join("、")) + " ";
				l += $("#week_begin_time").val().match("时间") ? "" : $("#week_begin_time").val();
				l += " 至 ";
				l += $("#week_end_time").val().match("时间") ? "" : $("#week_end_time").val();
				l += "</div>";
				$("#repeat_time").val(f.join(","));
				if($("#week_begin_day").val()) {
					$("#eventWeekDescHook").html(l)
				}
				break;
			case"3":
				var n = [], m = [], j = [], k = "", e = "", g = "", h = $("#eventDateIntermHook .interm-item");
				$.each(h, function(q, r) {
					var p = $(r);
					k = p.find(".interm_day").val();
					e = p.find(".intermBeginTime").val().match("时间") ? "" : p.find(".intermBeginTime").val();
					g = p.find(".intermEndTime").val().match("时间") ? "" : p.find(".intermEndTime").val();
					if(k) {
						m.push(k + " " + e + " 至 " + g)
					}
					n.push(k + " " + e + "~" + k + " " + g)
				});
				$.each(m, function(p, q) {
					l = '<div class="inner-item">';
					l += q;
					l += "</div>";
					j.push(l)
				});
				$("#eventIntermDescHook").html(j.join(""));
				$("#repeat_time").val(n.join("||"));
				break;
			default:
				return
		}
	}
	$("#addEventDaysHook").click(a);
	$("#eventDateIntermHook").delegate(".btn-cancel", "click", function(g) {
		g.preventDefault();
		var f = $("#eventDateIntermHook .interm-item").length - 1;
		if(f <= 49) {
			$("#addEventDaysHook").parent().show()
		}
		if(lowLevelBrowser) {
			$(this).parent().remove()
		} else {
			$(this).parent().slideUp("fast", function() {
				$(this).remove()
			})
		}
	});
	$("#eventTimeHook").delegate(".editable-select", "blur", function() {
		var e = $(this);
		if(e.val().match("时间")) {
			e.addClass("hint")
		} else {
			e.removeClass("hint")
		}
	});
	$("#repeat_type").bind("change", function() {
		var f = $(this).val(), e = $(this).parent().next();
		if(!e.children().eq(f).is(":visible")) {
			if(lowLevelBrowser) {
				e.children().hide()
			} else {
				e.children().slideUp("fast")
			}
		}
		if(lowLevelBrowser) {
			e.children().eq(f).show()
		} else {
			e.children().eq(f).slideDown("fast")
		}
		c(e.children().eq(f))
	});
	$("#repeat_type").trigger("change");
	$("body").click(b)
});
//ikphp地图弹出层
IK(function() {
	var a = /{(.+?)}/g;
	$.substitute = function(c, b) {
		return c.replace(a,
		function(e, d) {
			return typeof b[d] === "undefined" ? "": b[d]
		})
	}
});
var cardW = 388;
var cardH = 106;
var pinicon = window._pinicon_;
var staticMap = "http://maps.google.cn/maps/api/staticmap?size=" + cardW + "x" + cardH + "&zoom=13{loc}&markers=icon:" + pinicon + "|{coordinate}&sensor=false&language=zh-CN";
var empty_image = "http://maps.google.cn/maps/api/staticmap?size=388x106&amp;zoom=6&amp;center=北京,CN&amp;sensor=false&amp;language=zh-CN";
var previewMap = function(f, b) {
	var e = $(f).data("detail");
	var d = $(b).parent().parent().parent();
	var g = d.find(".map-card");
	var a = e.coordinate || "";
	if (a == "0.0,0.0") {
		a = ""
	}
	var h = $.substitute(staticMap, {
		loc: a ? "": "&center=" + (e.street_address || "北京"),
		coordinate: a ? "|" + a: ""
	});
	var c = ['<div class="map-card" style="margin: 5px 0 10px 18px;_margin: 5px 0 15px 10px;"><div class="bd">', '<a href="javascript:void(0);" data-type="known_address" class="lnk-modify-addr">', '<img src="{src}" width="' + cardW + '" height="' + cardH + '">', "", "</a>", '<div class="map-card-modify" ', "", '>已标记地点 <a href="javascript:void(0);" data-type="known_address" class="no-visited lnk-modify-addr">修改</a></div>', '<input type="hidden" id="selected_known_address" value="', a, '">', "</div></div>"];
	if (!a) {
		c[3] = '<span class="map-card-nomark">在地图上标记地点</span>';
		c[6] = 'style="display:none;"';
		h = empty_image
	}
	c = c.join("").replace("{src}", h);
	if (!g.length) {
		g = $(c).appendTo(d)
	} else {
		g = g.replaceWith(c)
	}
	$("#coordinate").val(a);
	g.find(".lnk-modify-addr").data("coordinate", a);
	$("#selected_known_address").data(e);
	$("#street_address").val(e.street_address || "");
	IK.updateCity(e.loc_id, e.district_id, e.region_id)
};




//验证
IK("validate", "editable-select", function() {
	function k(C, z) {
		var A = $(C).val().split("-");
		var B = $(z).val().split(":");
		return new Date(A[0], A[1] - 1, A[2], B[0], B[1])
	}

	function d(B) {
		var A = $("#repeat_type").val();
		if(B != A) {
			return false
		} else {
			switch(B) {
				case 0:
					return !$.trim($("#one_begin_day").val());
					break;
				case 1:
					return !$.trim($("#more_begin_day").val());
					break;
				case 2:
					return !$.trim($("#week_begin_day").val());
					break;
				case 3:
					var z = false;
					$("#eventDateIntermHook .interm_day").each(function(D, E) {
						var C = $(E);
						if(!$.trim(C.val())) {
							z = true
						}
					});
					return z;
					break;
				default:
					return true
			}
		}
	}

	function i(C) {
		var A = $("#repeat_type").val(), B = "", z = false;
		if(C != A) {
			return false
		} else {
			switch(C) {
				case 0:
					B = $.trim($("#one_begin_time").val());
					if(!B || B.match("时间")) {
						z = true
					}
					return z;
					break;
				case 1:
					B = $.trim($("#more_begin_time").val());
					if(!B || B.match("时间")) {
						z = true
					}
					return z;
					break;
				case 2:
					B = $.trim($("#week_begin_time").val());
					if(!B || B.match("时间")) {
						z = true
					}
					return z;
					break;
				case 3:
					$("#eventDateIntermHook .intermBeginTime").each(function(D, E) {
						B = $(E).val();
						if(!B || B.match("时间")) {
							z = true
						}
					});
					return z;
					break;
				default:
					return true
			}
		}
	}

	function a(D) {
		var B = $("#repeat_type").val(), z = /^(\d{1,2}):(\d{1,2})$/, C = "", A = false;
		if(D != B) {
			return false
		} else {
			switch(D) {
				case 0:
					C = $.trim($("#one_begin_time").val());
					return !z.test(C);
					break;
				case 1:
					C = $.trim($("#more_begin_time").val());
					return !z.test(C);
					break;
				case 2:
					C = $.trim($("#week_begin_time").val());
					return !z.test(C);
					break;
				case 3:
					$("#eventDateIntermHook .intermBeginTime").each(function(E, F) {
						C = $(F).val();
						if(!z.test(C)) {
							A = true
						}
					});
					return A;
					break;
				default:
					return true
			}
		}
	}

	function g(A) {
		var z = $("#repeat_type").val();
		if(A != z) {
			return false
		} else {
			switch(A) {
				case 1:
					return !$.trim($("#more_end_day").val());
					break;
				case 2:
					return !$.trim($("#week_end_day").val());
					break;
				default:
					return true
			}
		}
	}

	function t(C) {
		var A = $("#repeat_type").val(), B = "", z = false;
		if(C != A) {
			return false
		} else {
			switch(C) {
				case 0:
					B = $.trim($("#one_end_time").val());
					if(!B || B.match("时间")) {
						z = true
					}
					return z;
					break;
				case 1:
					B = $.trim($("#more_end_time").val());
					if(!B || B.match("时间")) {
						z = true
					}
					return z;
					break;
				case 2:
					B = $.trim($("#week_end_time").val());
					if(!B || B.match("时间")) {
						z = true
					}
					return z;
					break;
				case 3:
					$("#eventDateIntermHook .intermEndTime").each(function(D, E) {
						B = $(E).val();
						if(!B || B.match("时间")) {
							z = true
						}
					});
					return z;
					break;
				default:
					return true
			}
		}
	}

	function m(D) {
		var B = $("#repeat_type").val(), z = /^(\d{1,2}):(\d{1,2})$/, C = "", A = false;
		if(D != B) {
			return false
		} else {
			switch(D) {
				case 0:
					C = $.trim($("#one_end_time").val());
					return !z.test(C);
					break;
				case 1:
					C = $.trim($("#more_end_time").val());
					return !z.test(C);
					break;
				case 2:
					C = $.trim($("#week_end_time").val());
					return !z.test(C);
					break;
				case 3:
					$("#eventDateIntermHook .intermEndTime").each(function(E, F) {
						C = $(F).val();
						if(!z.test(C)) {
							A = true
						}
					});
					return A;
					break;
				default:
					return true
			}
		}
	}

	function o(B) {
		var A = $("#repeat_type").val(), z = false;
		if(B != A) {
			return false
		} else {
			switch(B) {
				case 0:
					return k("#one_begin_day", "#one_begin_time") > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
					break;
				case 1:
					return k("#more_begin_day", "#more_begin_time") > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
					break;
				case 2:
					return k("#week_begin_day", "#week_begin_time") > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
					break;
				case 3:
					$("#eventDateIntermHook .interm-item").each(function(D, E) {
						var C = $(E);
						if(k(C.find(".interm_day"), C.find(".intermBeginTime")) > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000)) {
							z = true
						}
					});
					return z;
					break;
				default:
					return true
			}
		}
	}

	function c(D) {
		var B = $("#repeat_type").val(), A = false, C, z;
		if(D != B) {
			return false
		} else {
			switch(D) {
				case 0:
					C = k("#one_begin_day", "#one_begin_time");
					z = k("#one_begin_day", "#one_end_time");
					return z <= C;
					break;
				case 1:
					C = k("#more_begin_day", "#more_begin_time");
					z = k("#more_begin_day", "#more_end_time");
					return z <= C;
					break;
				case 2:
					C = k("#week_begin_day", "#week_begin_time");
					z = k("#week_begin_day", "#week_end_time");
					return z <= C;
					break;
				case 3:
					$("#eventDateIntermHook .interm-item").each(function(F, G) {
						var E = $(G);
						C = k(E.find(".interm_day"), E.find(".intermBeginTime"));
						z = k(E.find(".interm_day"), E.find(".intermEndTime"));
						if(z <= C) {
							A = true
						}
					});
					return A;
					break;
				default:
					return true
			}
		}
	}

	function u(C) {
		var A = $("#repeat_type").val(), B, z;
		if(C != A) {
			return false
		} else {
			switch(C) {
				case 1:
					B = k("#more_begin_day", "#more_begin_time");
					z = k("#more_end_day", "#more_begin_time");
					return z < B;
					break;
				case 2:
					B = k("#week_begin_day", "#week_begin_time");
					z = k("#week_end_day", "#week_begin_time");
					return z < B;
					break;
				default:
					return true
			}
		}
	}

	function f(D) {
		var A = $("#repeat_type").val(), C, z;
		if(D != A) {
			return false
		} else {
			switch(D) {
				case 1:
					C = k("#more_begin_day", "#more_begin_time");
					z = k("#more_end_day", "#more_begin_time");
					return z > new Date(C.getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
					break;
				case 2:
					C = k("#week_begin_day", "#week_begin_time");
					z = k("#week_end_day", "#week_begin_time");
					return z > new Date(C.getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
					break;
				case 3:
					var B = [];
					$("#eventDateIntermHook .interm-item").each(function(F, G) {
						var E = $(G);
						B.push(k(E.find(".interm_day"), E.find(".intermEndTime")).getTime())
					});
					B.sort();
					return ((B[B.length - 1] - B[0]) > 3 * 30 * 24 * 60 * 60 * 1000);
					break;
				default:
					return true
			}
		}
	}

	function h(B) {
		var A = $("#repeat_type").val(), z = false;
		if(B != A) {
			return false
		} else {
			switch(B) {
				case 0:
					return k("#one_begin_day", "#one_begin_time") < new Date();
					break;
				case 1:
					return k("#more_begin_day", "#more_begin_time") < new Date();
					break;
				case 2:
					return k("#week_begin_day", "#week_begin_time") < new Date();
					break;
				case 3:
					$("#eventDateIntermHook .interm-item").each(function(D, E) {
						z = true;
						var C = $(E);
						if(k(C.find(".interm_day"), C.find(".intermEndTime")) > new Date()) {
							z = false
						}
					});
					return z;
					break;
				default:
					return true
			}
		}
	}

	function y() {
		var z = $("#repeat_type").val();
		if(z != 2) {
			return false
		} else {
			return !$("#eventDateWeekHook .week-label input:checked").length
		}
	}

	function w() {
		var z = false;
		if($("#eform input[name=fee]:checked").val() == "1") {
			$.each($("#eform .fee-num"), function(A, B) {
				if(!$(B).val()) {
					z = true
				}
			})
		}
		return z
	}

	function x() {
		var z = false;
		if($("#eform input[name=fee]:checked").val() == "1") {
			$.each($("#eform .fee-num"), function(A, B) {
				if(!/\d+/.test($(B).val())) {
					z = true
				}
			})
		}
		return z
	}

	function s(C) {
		var z = $("#repeat_type").val(), B = $("#begin_date"), D = $("#begin_time"), E = $("#end_date"), F = $("#end_time"), A = $("#repeat_time");
		if(C != z) {
			return false
		} else {
			B.val();
			D.val();
			E.val();
			F.val();
			A.val();
			switch(C) {
				case 0:
					B.val($("#one_begin_day").val());
					D.val($("#one_begin_time").val());
					E.val($("#one_begin_day").val());
					F.val($("#one_end_time").val());
					break;
				case 1:
					B.val($("#more_begin_day").val());
					D.val($("#more_begin_time").val());
					E.val($("#more_end_day").val());
					F.val($("#more_end_time").val());
					break;
				case 2:
					B.val($("#week_begin_day").val());
					D.val($("#week_begin_time").val());
					E.val($("#week_end_day").val());
					F.val($("#week_end_time").val());
					$("body").trigger("click");
					break;
				case 3:
					$("body").trigger("click");
					break
			}
		}
	}

	var e = $("#type");
	var r = $("#loc_id");
	var n = $("#district_id");
	var p = $("#street_address");
	var b = {
		loc : "城市名",
		street_address : "详细地址",
		tags : "多个标签用空格区分"
	};
	var v = {
		title : {
			isNull : "请输入活动标题",
			tooLong : "最多32个汉字"
		},
		type : {
			isNull : "请选择活动类型"
		},
		subtype : {
			isNull : "请选择活动子类型"
		},
		oneDayTime : {
			begin_day_isNull : "请输入开始日期",
			begin_time_isNull : "请选择开始时间",
			begin_time_invalidFormat : "请输入正确的开始时间",
			end_time_isNull : "请输入结束时间",
			end_time_invalidFormat : "请输入正确的结束时间",
			start_end_time : "结束时间不能早于起始时间"
		},
		continueTime : {
			begin_day_isNull : "请输入开始日期",
			begin_time_isNull : "请选择开始时间",
			begin_time_invalidFormat : "请输入正确的开始时间",
			end_day_isNull : "请输入结束日期",
			end_time_isNull : "请输入结束时间",
			end_time_invalidFormat : "请输入正确的结束时间",
			start_end_date : "结束日期不能早于起始日期",
			start_end_time : "结束时间不能早于起始时间",
			last_three_months : "活动持续时间不能大于3个月"
		},
		weekTime : {
			begin_day_isNull : "请输入开始日期",
			begin_time_isNull : "请选择开始时间",
			begin_time_invalidFormat : "请输入正确的开始时间",
			end_day_isNull : "请输入结束日期",
			end_time_isNull : "请输入结束时间",
			end_time_invalidFormat : "请输入正确的结束时间",
			start_end_date : "结束日期不能早于起始日期",
			start_end_time : "结束时间不能早于起始时间",
			last_three_months : "活动持续时间不能大于3个月",
			select_week_day : "请至少选择周内的一天"
		},
		intermTime : {
			begin_day_isNull : "请输入开始日期",
			begin_time_isNull : "请选择开始时间",
			begin_time_invalidFormat : "请输入正确的开始时间",
			end_time_isNull : "请输入结束时间",
			end_time_invalidFormat : "请输入正确的结束时间",
			start_end_time : "结束时间不能早于起始时间",
			last_three_months : "活动持续时间不能大于3个月",
			has_started : "活动结束时间已过"
		},
		address : {
			loc_id_isNull : "请输入城市",
			district_isNull : "请选择城区",
			street_address_isNull : "请输入具体地址"
		},
		desc : {
			isNull : "请输入简介",
			tooLong : "最多4000个汉字"
		},
		feeNum : {
			isNull : "请填写价格",
			notNumber : "价格必须是数字"
		},
		feeValue : {
			isNull : "请设置活动费用"
		},
		tags : {
			tooLong : "最多100个字符"
		}
	};
	var l = {
		title : {
			elems : "#title",
			isNull : function(z) {
				return !$.trim(z.val())
			},
			tooLong : function(z) {
				return $.trim(z.val()).replace(/[^\x00-\xff]/g, "豆瓣").length > 64
			}
		},
		type : {
			elems : "#type",
			isNull : function(z) {
				return z.val() == 0
			}
		},
		subtype : {
			elems : "#subtype",
			isNull : function(B) {
				var A = $("#type").val();
				var z = "#subtype_" + A;
				if($(z).length) {
					return B.val() == 0
				} else {
					return false
				}
			}
		},
		oneDayTime : {
			elems : "#one_end_time",
			begin_day_isNull : function() {
				return d(0)
			},
			begin_time_isNull : function() {
				return i(0)
			},
			begin_time_invalidFormat : function() {
				return a(0)
			},
			end_time_isNull : function() {
				return t(0)
			},
			end_time_invalidFormat : function() {
				return m(0)
			},
			start_end_time : function() {
				return c(0)
			},
			writeData : function() {
				s(0);
				return false
			}
		},
		continueTime : {
			elems : "#more_end_time",
			begin_day_isNull : function() {
				return d(1)
			},
			begin_time_isNull : function() {
				return i(1)
			},
			begin_time_invalidFormat : function() {
				return a(1)
			},
			end_day_isNull : function() {
				return g(1)
			},
			end_time_isNull : function() {
				return t(1)
			},
			end_time_invalidFormat : function() {
				return m(1)
			},
			start_end_date : function() {
				return u(1)
			},
			start_end_time : function() {
				return c(1)
			},
			last_three_months : function() {
				return f(1)
			},
			writeData : function() {
				s(1);
				return false
			}
		},
		weekTime : {
			elems : "#week_end_time",
			begin_day_isNull : function() {
				return d(2)
			},
			begin_time_isNull : function() {
				return i(2)
			},
			begin_time_invalidFormat : function() {
				return a(2)
			},
			end_day_isNull : function() {
				return g(2)
			},
			end_time_isNull : function() {
				return t(2)
			},
			end_time_invalidFormat : function() {
				return m(2)
			},
			start_end_date : function() {
				return u(2)
			},
			start_end_time : function() {
				return c(2)
			},
			last_three_months : function() {
				return f(2)
			},
			select_week_day : function() {
				return y()
			},
			writeData : function() {
				s(2);
				return false
			}
		},
		intermTime : {
			elems : '#eventDateIntermHook .intermEndTime:input[type="text"]',
			begin_day_isNull : function() {
				return d(3)
			},
			begin_time_isNull : function() {
				return i(3)
			},
			begin_time_invalidFormat : function() {
				return a(3)
			},
			end_time_isNull : function() {
				return t(3)
			},
			end_time_invalidFormat : function() {
				return m(3)
			},
			start_end_time : function() {
				return c(3)
			},
			has_started : function() {
				return h(3)
			},
			last_three_months : function() {
				return f(3)
			},
			writeData : function() {
				s(3);
				return false
			}
		},
		address : {
			elems : "#street_address",
			loc_id_isNull : function() {
				var z = $("#sel-address-type1");
				if(z.length > 0 && !z[0].checked) {
					return
				}
				return !$.trim(r.val())
			},
			district_isNull : function() {
				var z = $("#sel-address-type1");
				if(z.length > 0 && !z[0].checked) {
					return
				}
				if(n.find("option").length <= 1) {
					return
				}
				return n.val() === "0"
			},
			street_address_isNull : function() {
				var z = $("#sel-address-type1");
				if(z.length > 0 && !z[0].checked) {
					return
				}
				return !$.trim(p.val())
			}
		},
		desc : {
			elems : "#desc",
			isNull : function(z) {
				return !$.trim(z.val())
			},
			tooLong : function(z) {
				return z.val().length > 4000
			}
		},
		feeNum : {
			elems : ".fee-num",
			isNull : function() {
				return w()
			},
			notNumber : function() {
				return x()
			}
		},
		feeValue : {
			elems : ".fee-value",
			isNull : function() {
				return !$("#eform input[name=fee]:checked").length
			}
		},
		tags : {
			elems : "#tags",
			tooLong : function(z) {
				return z.val().length > 100
			}
		}
	};
	var j = {
		callback : function(z) {
			var A = $("#submit_form").val();
			$("#submit_form").val("正在提交，请稍后...").unbind("click");
			$.post("/j/location/create_event", $(z).serialize(), function(B) {
				if(B.r) {
					$(window).unbind();
					if($("#event_id").length) {
						window.location.href = IK_BASE_URL + "/event/" + B.id + "/"
					} else {
						window.location.href = IK_BASE_URL + "/event/" + B.id + "/upload_poster"
					}
				} else {
					if("error_desc" in B) {
						alert(B.error_desc)
					} else {
						alert("创建失败，请正确填写各项内容")
					}
					$("#submit_form").val(A).bind("click", q)
				}
			})
		}
	};
	$("#eform").bind("hasError", function() {
		var z = $(this);
		if(z.find(".has-error").length > 0) {
			$("html, body").animate({
				scrollTop : z.find(".has-error:first").offset().top
			});
			return
		}
	}).validateForm(l, v, b, j);
	function q() {
		$("body").trigger("click");
		$("#eform").trigger("submit")
	}
	$("#submit_form").bind("click", q);
	$("#cancel_form").click(function() {
		history.go(-1)
	})
}); 
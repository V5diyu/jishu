webpackJsonp([10],{

/***/ 517:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(585)

var Component = __webpack_require__(202)(
  /* script */
  __webpack_require__(534),
  /* template */
  __webpack_require__(570),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 534:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_service_js__ = __webpack_require__(136);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            status: 0,
            tableData: [],
            loading: true,
            pn: 1,
            pageSize: 15,
            count: 0,

            curRow: {},
            curIndex: 0,

            newItem: {},
            activeName: 'first',
            dialogVisible: false,
            detail: {},
            flow1: {},
            flow2: {},
            flow3: {},
            flow4: {},
            flow5: {},
            flow6: {},
            flow7: {},
            flow8: {},
            flow9: {},
            flow10: {}
        };
    },
    created() {
        this.getData();
    },
    filters: {
        time(value) {
            return new Date(parseInt(value) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
        }
    },
    methods: {
        exportExl(index, row) {
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].baseURL + '/admin/dispatch/ex?userId=' + row.userId + '&invoiceId=' + row.invoiceId;
        },
        addNewItem() {
            this.newItem.userId = this.curRow.userId;
            this.newItem.bill = '无';
            this.newItem.type = '增项';
            this.newItem.invoiceId = this.curRow.invoiceId;
            this.$axios.post('addDispatch', this.newItem, res => {
                if (res.ret == true) {
                    this.detail.dispatchList.unshift(this.newItem);
                    this.newItem = {};
                }
            });
        },
        handleClick(tab, event) {
            console.log(tab, event);
        },
        getInfo(index, row) {
            this.curIndex = index;
            this.curRow = row;
            this.dialogVisible = true;
            this.$axios.post('getDispatchDetail', {
                userId: row.userId,
                invoiceId: row.invoiceId
            }, res => {
                if (res.ret == true) {
                    this.detail = res.data;
                    this.flow1 = res.data.flow1;
                    this.flow2 = res.data.flow2;
                    this.flow3 = res.data.flow3;
                    this.flow4 = res.data.flow4;
                    this.flow5 = res.data.flow5;
                    this.flow6 = res.data.flow6;
                    this.flow7 = res.data.flow7;
                    this.flow8 = res.data.flow8;
                    this.flow9 = res.data.flow9;
                    this.flow10 = res.data.flow10;
                }
            });
        },
        audit() {
            this.$axios.post('getDispatchAudit', {
                id: this.curRow.id
            }, res => {
                if (res.ret == true) {
                    this.dialogVisible = false;
                    this.tableData.splice(this.curIndex, 1);
                    this.$message.success('通过成功');
                }
            });
        },
        handleCurrentChange(val) {
            this.pn = val;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getDispatch', {
                pn: this.pn,
                status: this.status
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        del(index, row) {
            this.$confirm('确定删除该类型?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.$axios.post('delLog', {
                    id: row.id
                }, res => {
                    this.$message.success('删除成功');
                    this.tableData.splice(index, 1);
                });
            }).catch(() => {
                this.$message.info('已取消删除');
            });
        }
    }
});

/***/ }),

/***/ 554:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(135)(undefined);
// imports


// module
exports.push([module.i, ".el-step__description p{color:#666;font-size:14px;line-height:2}.ticket-img{height:100px;width:200px;background-repeat:no-repeat;background-size:cover;background-position:50%;border-radius:4px;margin:20px 0}.name-wrapper{height:22px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}", ""]);

// exports


/***/ }),

/***/ 570:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "table"
  }, [_c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-breadcrumb', {
    attrs: {
      "separator": "/"
    }
  }, [_c('el-breadcrumb-item', [_c('i', {
    staticClass: "el-icon-menu"
  }), _vm._v("报销管理")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-radio-group', {
    on: {
      "change": _vm.getData
    },
    model: {
      value: (_vm.status),
      callback: function($$v) {
        _vm.status = $$v
      },
      expression: "status"
    }
  }, [_c('el-radio-button', {
    attrs: {
      "label": "0"
    }
  }, [_vm._v("未审批")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "1"
    }
  }, [_vm._v("已审批")])], 1)], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
    directives: [{
      name: "loading",
      rawName: "v-loading.body",
      value: (_vm.loading),
      expression: "loading",
      modifiers: {
        "body": true
      }
    }],
    staticStyle: {
      "width": "100%"
    },
    attrs: {
      "data": _vm.tableData,
      "border": ""
    }
  }, [_c('el-table-column', {
    attrs: {
      "prop": "customer",
      "label": "客户名称",
      "width": "170"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "技术人员"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return _vm._l((scope.row.appoint), function(a) {
          return (a.emplId == scope.row.userId) ? _c('span', [_vm._v(_vm._s(a.name))]) : _vm._e()
        })
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "type",
      "label": "服务类型"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "create",
      "label": "报销时间"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "180"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
          attrs: {
            "size": "small",
            "type": "success"
          },
          on: {
            "click": function($event) {
              _vm.getInfo(scope.$index, scope.row)
            }
          }
        }, [_vm._v("查看详情")]), _vm._v(" "), _c('el-button', {
          attrs: {
            "size": "small",
            "type": "primary"
          },
          on: {
            "click": function($event) {
              _vm.exportExl(scope.$index, scope.row)
            }
          }
        }, [_vm._v("导出")])]
      }
    }])
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "pagination"
  }, [_c('el-pagination', {
    attrs: {
      "layout": "prev, pager, next",
      "total": _vm.count,
      "page-size": _vm.pageSize
    },
    on: {
      "current-change": _vm.handleCurrentChange
    }
  })], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": "报销详情",
      "width": "80%",
      "visible": _vm.dialogVisible
    },
    on: {
      "update:visible": function($event) {
        _vm.dialogVisible = $event
      }
    }
  }, [_c('el-tabs', {
    on: {
      "tab-click": _vm.handleClick
    },
    model: {
      value: (_vm.activeName),
      callback: function($$v) {
        _vm.activeName = $$v
      },
      expression: "activeName"
    }
  }, [_c('el-tab-pane', {
    attrs: {
      "label": "基本信息",
      "name": "first"
    }
  }, [_c('el-row', {
    attrs: {
      "gutter": 20
    }
  }, [_c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-card', {
    staticClass: "box-card"
  }, [_c('div', {
    staticClass: "clearfix",
    attrs: {
      "slot": "header"
    },
    slot: "header"
  }, [_c('span', [_vm._v("客户信息")])]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("销售单号：" + _vm._s(_vm.detail.code))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("客户名称：" + _vm._s(_vm.detail.customer))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("单位名称：" + _vm._s(_vm.detail.company))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("前往地点：" + _vm._s(_vm.detail.place))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("详细地址：" + _vm._s(_vm.detail.address))]), _vm._v(" "), _vm._l((_vm.detail.contact), function(item) {
    return _c('div', {
      staticClass: "text item"
    }, [_vm._v("联系人：" + _vm._s(item.name) + "/" + _vm._s(item.tel))])
  })], 2)], 1), _vm._v(" "), _c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-card', {
    staticClass: "box-card"
  }, [_c('div', {
    staticClass: "clearfix",
    attrs: {
      "slot": "header"
    },
    slot: "header"
  }, [_c('span', [_vm._v("预收费用")])]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("服务天数：" + _vm._s(_vm.detail.days))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("服务人数：" + _vm._s(_vm.detail.peoples))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("交通费：" + _vm._s(_vm.detail.traffic))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("住宿费（单日）：" + _vm._s(_vm.detail.stayCharge))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("服务费（单日）：" + _vm._s(_vm.detail.serviceCharge))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("合计：￥" + _vm._s(_vm.detail.days * _vm.detail.peoples * (Number(_vm.detail.stayCharge) + Number(_vm.detail.serviceCharge)) + Number(_vm.detail.traffic)))])])], 1)], 1), _vm._v(" "), _c('el-row', {
    staticStyle: {
      "margin-top": "20px"
    },
    attrs: {
      "gutter": 20
    }
  }, [_c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-card', {
    staticClass: "box-card"
  }, [_c('div', {
    staticClass: "clearfix",
    attrs: {
      "slot": "header"
    },
    slot: "header"
  }, [_c('span', [_vm._v("服务内容")])]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("服务类型：" + _vm._s(_vm.detail.type))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("单位数量：" + _vm._s(_vm.detail.number))]), _vm._v(" "), _vm._l((_vm.detail.device), function(item) {
    return _c('div', {
      staticClass: "text item"
    }, [_vm._v("设备名称/数量：" + _vm._s(item.name) + "/" + _vm._s(item.number))])
  }), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("备注说明：" + _vm._s(_vm.detail.remark))])], 2)], 1), _vm._v(" "), _c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-card', {
    staticClass: "box-card"
  }, [_c('div', {
    staticClass: "clearfix",
    attrs: {
      "slot": "header"
    },
    slot: "header"
  }, [_c('span', [_vm._v("技术申请信息")])]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("申请人：" + _vm._s(_vm.detail.name))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("申请日期：" + _vm._s(_vm.detail.create))])])], 1)], 1), _vm._v(" "), _c('el-row', {
    staticStyle: {
      "margin-top": "20px"
    },
    attrs: {
      "gutter": 20
    }
  }, [(_vm.detail.addDaysInfo) ? _c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-card', {
    staticClass: "box-card"
  }, [_c('div', {
    staticClass: "clearfix",
    attrs: {
      "slot": "header"
    },
    slot: "header"
  }, [_c('span', [_vm._v("新增天数")])]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("服务天数：" + _vm._s(_vm.detail.addDaysInfo.days))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("服务人数：" + _vm._s(_vm.detail.addDaysInfo.peoples))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("交通费：" + _vm._s(_vm.detail.addDaysInfo.traffic))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("住宿费（单日）：" + _vm._s(_vm.detail.addDaysInfo.stayCharge))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("服务费（单日）：" + _vm._s(_vm.detail.addDaysInfo.serviceCharge))]), _vm._v(" "), _c('div', {
    staticClass: "text item"
  }, [_vm._v("合计：￥" + _vm._s(_vm.detail.addDaysInfo.days * _vm.detail.addDaysInfo.peoples * (Number(_vm.detail.addDaysInfo.stayCharge) + Number(_vm.detail.addDaysInfo.serviceCharge)) + Number(_vm.detail.addDaysInfo.traffic)))])])], 1) : _vm._e()], 1)], 1), _vm._v(" "), _c('el-tab-pane', {
    attrs: {
      "label": "出差流程",
      "name": "second"
    }
  }, [_c('el-steps', {
    attrs: {
      "direction": "vertical",
      "active": 10,
      "process-status": "finish"
    }
  }, [(_vm.flow1) ? _c('el-step', {
    attrs: {
      "title": "客户电话沟通"
    }
  }, [_c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("服务类型："), _vm._l((_vm.flow1.type), function(item) {
    return _c('span', [_vm._v(_vm._s(item))])
  })], 2), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("单位数量："), _c('span', [_vm._v(_vm._s(_vm.flow1.number))])]), _vm._v(" "), _vm._l((_vm.flow1.device), function(item) {
    return _c('p', {
      attrs: {
        "slot": "description"
      },
      slot: "description"
    }, [_vm._v("设备名称/数量："), _c('span', [_vm._v(_vm._s(item.name) + "/" + _vm._s(item.number))])])
  }), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow1.create)))])])], 2) : _vm._e(), _vm._v(" "), (_vm.flow2) ? _c('el-step', {
    attrs: {
      "title": "计划安排"
    }
  }, _vm._l((_vm.flow2), function(item) {
    return _c('p', {
      attrs: {
        "slot": "description"
      },
      slot: "description"
    }, [_c('span', [_vm._v(_vm._s(item.description))])])
  })) : _vm._e(), _vm._v(" "), (_vm.flow3) ? _c('el-step', {
    attrs: {
      "title": "借用设备申请"
    }
  }, [_vm._l((_vm.flow3.device), function(item) {
    return _c('p', {
      attrs: {
        "slot": "description"
      },
      slot: "description"
    }, [_vm._v("设备信息："), _c('span', [_vm._v(_vm._s(item.code) + "/" + _vm._s(item.name) + "/" + _vm._s(item.number))])])
  }), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow3.create)))])])], 2) : _vm._e(), _vm._v(" "), (_vm.flow4) ? _c('el-step', {
    attrs: {
      "title": "确定出发日期"
    }
  }, [_c('p', {
    staticClass: "ticket-img",
    style: ({
      'background-image': 'url(' + _vm.flow4.url + ')'
    }),
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("出发日期："), _c('span', [_vm._v(_vm._s(_vm.flow4.date))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("备注："), _c('span', [_vm._v(_vm._s(_vm.flow4.remark))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow4.create)))])])]) : _vm._e(), _vm._v(" "), (_vm.flow5) ? _c('el-step', {
    attrs: {
      "title": "现场问题确认"
    }
  }, [_c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("服务类型："), _vm._l((_vm.flow5.type), function(item) {
    return _c('span', [_vm._v(_vm._s(item))])
  })], 2), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("单位数量："), _c('span', [_vm._v(_vm._s(_vm.flow5.number))])]), _vm._v(" "), _vm._l((_vm.flow5.device), function(item) {
    return _c('p', {
      attrs: {
        "slot": "description"
      },
      slot: "description"
    }, [_vm._v("设备名称/数量："), _c('span', [_vm._v(_vm._s(item.name) + "/" + _vm._s(item.number))])])
  }), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow5.create)))])])], 2) : _vm._e(), _vm._v(" "), (_vm.flow6) ? _c('el-step', {
    attrs: {
      "title": "技术支持进行"
    }
  }, [_c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("完成进度："), _c('span', [_vm._v(_vm._s(_vm.flow6.percentage))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("进度状态："), _c('span', [_vm._v(_vm._s(_vm.flow6.status))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("备注说明："), _c('span', [_vm._v(_vm._s(_vm.flow6.remark))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow6.create)))])])]) : _vm._e(), _vm._v(" "), (_vm.flow7) ? _c('el-step', {
    attrs: {
      "title": "销售确认结束"
    }
  }, [_c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("备注说明："), _c('span', [_vm._v(_vm._s(_vm.flow7.remark))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow7.create)))])])]) : _vm._e(), _vm._v(" "), (_vm.flow8) ? _c('el-step', {
    attrs: {
      "title": "确定返程日期"
    }
  }, [_c('p', {
    staticClass: "ticket-img",
    style: ({
      'background-image': 'url(' + _vm.flow8.url + ')'
    }),
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("出发日期："), _c('span', [_vm._v(_vm._s(_vm.flow8.date))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("备注："), _c('span', [_vm._v(_vm._s(_vm.flow8.remark))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow8.create)))])])]) : _vm._e(), _vm._v(" "), (_vm.flow9) ? _c('el-step', {
    attrs: {
      "title": "出差财务报销"
    }
  }, [_c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow9.create)))])])]) : _vm._e(), _vm._v(" "), (_vm.flow10) ? _c('el-step', {
    attrs: {
      "title": "出差项目总结"
    }
  }, [_c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("备用金："), _c('span', [_vm._v(_vm._s(_vm.flow10.amount))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("备注："), _c('span', [_vm._v(_vm._s(_vm.flow10.remark))])]), _vm._v(" "), _c('p', {
    attrs: {
      "slot": "description"
    },
    slot: "description"
  }, [_vm._v("时间："), _c('span', [_vm._v(_vm._s(_vm._f("time")(_vm.flow10.create)))])])]) : _vm._e()], 1)], 1), _vm._v(" "), _c('el-tab-pane', {
    attrs: {
      "label": "报销审批",
      "name": "three"
    }
  }, [_c('el-table', {
    staticStyle: {
      "width": "100%"
    },
    attrs: {
      "data": _vm.detail.dispatchList,
      "border": "",
      "show-summary": ""
    }
  }, [_c('el-table-column', {
    attrs: {
      "prop": "place",
      "label": "地点"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "type",
      "label": "类型"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "amount",
      "label": "金额"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "bill",
      "label": "票据"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "remark",
      "label": "描述"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "create",
      "label": "时间"
    }
  })], 1), _vm._v(" "), (_vm.curRow.status == 0) ? _c('p', {
    staticStyle: {
      "font-size": "20px",
      "font-weight": "bold",
      "margin-top": "10px"
    }
  }, [_vm._v("增项")]) : _vm._e(), _vm._v(" "), (_vm.curRow.status == 0) ? _c('el-form', {
    staticClass: "demo-form-inline",
    attrs: {
      "inline": true,
      "model": _vm.newItem
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "金额（可负值）"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "number",
      "placeholder": "请输入正负值"
    },
    model: {
      value: (_vm.newItem.amount),
      callback: function($$v) {
        _vm.$set(_vm.newItem, "amount", $$v)
      },
      expression: "newItem.amount"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "备注"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "增项备注"
    },
    model: {
      value: (_vm.newItem.remark),
      callback: function($$v) {
        _vm.$set(_vm.newItem, "remark", $$v)
      },
      expression: "newItem.remark"
    }
  })], 1), _vm._v(" "), _c('el-form-item', [_c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.addNewItem
    }
  }, [_vm._v("添加")])], 1)], 1) : _vm._e()], 1)], 1), _vm._v(" "), (_vm.curRow.status == 0) ? _c('span', {
    staticClass: "dialog-footer",
    attrs: {
      "slot": "footer"
    },
    slot: "footer"
  }, [_c('el-button', {
    on: {
      "click": function($event) {
        _vm.dialogVisible = false
      }
    }
  }, [_vm._v("取 消")]), _vm._v(" "), _c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.audit
    }
  }, [_vm._v("通 过")])], 1) : _vm._e()], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 585:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(554);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(203)("1ef7bfde", content, true);

/***/ })

});
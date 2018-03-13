webpackJsonp([11],{

/***/ 516:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(584)

var Component = __webpack_require__(202)(
  /* script */
  __webpack_require__(533),
  /* template */
  __webpack_require__(569),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 533:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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
            tableData: [],
            loading: true,
            pn: 1,
            pageSize: 15,
            count: 0,

            addDialogVisible: false,
            addDialogTitle: '添加审批人员',
            form: {
                approve: '',
                name: ''
            }
        };
    },
    created() {
        this.getData();
    },
    methods: {
        handleCurrentChange(val) {
            this.pn = val;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getApprove', {
                pn: this.pn
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        addDialog() {
            this.addDialogVisible = true;
            this.addDialogTitle = '添加审批人员';
            this.form = {
                approve: '',
                name: ''
            };
        },
        add() {
            let self = this;

            if (self.form.id) {
                this.$axios.post('updateApprove', self.form, res => {
                    if (res.ret == true) {
                        self.getData();
                        self.addDialogVisible = false;
                        self.$message.success('修改成功');
                    }
                });
            } else {
                this.$axios.post('addApprove', self.form, res => {
                    if (res.ret == true) {
                        self.getData();
                        self.addDialogVisible = false;
                        self.$message.success('添加成功');
                    }
                });
            }
        },
        update(index, row) {
            this.addDialogVisible = true;
            this.addDialogTitle = '修改审批人员';
            this.form = row;
        }
    }
});

/***/ }),

/***/ 553:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(135)(undefined);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 569:
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
  }), _vm._v("配置")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("审批人员")])], 1)], 1)], 1), _vm._v(" "), (_vm.count < 2) ? _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  }, [_c('el-button', {
    staticStyle: {
      "float": "right"
    },
    attrs: {
      "type": "primary",
      "icon": "plus"
    },
    on: {
      "click": _vm.addDialog
    }
  }, [_vm._v("添加审批人员")])], 1)], 1)], 1) : _vm._e(), _vm._v(" "), _c('el-table', {
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
      "prop": "approve",
      "label": "审批人员用户ID"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "name",
      "label": "审批人员名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "80"
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
              _vm.update(scope.$index, scope.row)
            }
          }
        }, [_vm._v("修改")])]
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
      "title": _vm.addDialogTitle,
      "visible": _vm.addDialogVisible
    },
    on: {
      "update:visible": function($event) {
        _vm.addDialogVisible = $event
      }
    }
  }, [_c('el-form', {
    ref: "form",
    attrs: {
      "model": _vm.form,
      "label-width": "120px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "审批人员用户ID"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入审批人员用户ID"
    },
    model: {
      value: (_vm.form.approve),
      callback: function($$v) {
        _vm.$set(_vm.form, "approve", $$v)
      },
      expression: "form.approve"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "审批人员名称"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入审批人员名称"
    },
    model: {
      value: (_vm.form.name),
      callback: function($$v) {
        _vm.$set(_vm.form, "name", $$v)
      },
      expression: "form.name"
    }
  })], 1)], 1), _vm._v(" "), _c('span', {
    staticClass: "dialog-footer",
    attrs: {
      "slot": "footer"
    },
    slot: "footer"
  }, [_c('el-button', {
    on: {
      "click": function($event) {
        _vm.addDialogVisible = false
      }
    }
  }, [_vm._v("取 消")]), _vm._v(" "), _c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.add
    }
  }, [_vm._v("确 定")])], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 584:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(553);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(203)("4bcfdbd1", content, true);

/***/ })

});
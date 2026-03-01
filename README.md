# Panda 子主题

基于 Zibll 主题的子主题封装，用于隔离自定义修改，支持主题升级后快速恢复。

## 架构

```
panda/
├── func.php                       # 子主题入口（加载 xingxy 模块）
├── style.css                      # 子主题声明
├── zibpay/functions/              # 直接修改父主题文件的 overlay
│   └── zibpay-points.php          # 积分任务页（含 TG Bot 引流卡片）
└── xingxy/                        # 独立功能模块（Git 子仓库）
    ├── README.md                  # 功能清单
    ├── inc/                       # PHP 功能文件
    ├── assets/                    # CSS/JS 前端资源
    ├── patches/                   # 补丁文档（主题更新恢复参考）
    └── ...
```

## 自定义修改索引

### 父主题文件修改（需主题更新后恢复）

所有对主题核心文件的修改，均记录在 [`xingxy/patches/`](xingxy/patches/README.md) 目录中。

主要涉及：

| 修改类型 | 涉及文件 | 补丁文档 |
|----------|----------|----------|
| 数量限制 | `shop/admin/options/term-option.php` 等 | [patches/README.md](xingxy/patches/README.md) |
| 阶梯优惠互斥 | `shop/inc/discount.php` | [tiered-discount-mutual-exclusion.md](xingxy/patches/tiered-discount-mutual-exclusion.md) |
| 邀请注册积分 | `zibpay-points.php` | [referral-points.md](xingxy/patches/referral-points.md) |
| 邮件修复 | `functions.php` | [email-fix.md](xingxy/patches/email-fix.md) |
| 发货邮件控制 | `zibpay-order.php` | [shipping-email-control.md](xingxy/patches/shipping-email-control.md) |
| VIP 引导 | `shop/page/pay.php` | [shop-vip-promo.md](xingxy/patches/shop-vip-promo.md) |
| 推广链接伪装 | `footer.php` 等 | [referral-tracker-rebate-fix.md](xingxy/patches/referral-tracker-rebate-fix.md) |
| 卡密发货守护 | `pay.php`, `action.php` 等 | [shipping-guard-fix.md](xingxy/patches/shipping-guard-fix.md) |
| 商品发布增强 | `sidebar.php` 等 | [newproduct-enhancement.md](xingxy/patches/newproduct-enhancement.md) |
| TG Bot 引流 | `zibpay-points.php` | [tg-bot-integration.md](xingxy/patches/tg-bot-integration.md) |

### 独立功能模块（不修改父主题）

通过 WordPress hooks 实现，无需恢复：

- 商城优惠码集成
- 控制台净化
- 前台商品发布系统
- 卡密管理系统
- 推广返佣前台设置
- TG Bot 积分互通（配合 zibll-oauth 插件）

详见 [xingxy/README.md](xingxy/README.md)

## 关联项目

| 项目 | 路径 | 说明 |
|------|------|------|
| **xingxy** | `themes/panda/xingxy/` | 自定义功能模块（独立 Git 仓库） |
| **zibll-oauth** | `plugins/zibll-oauth-main/` | OAuth2 授权服务 + 积分互通 REST 端点 |
| **tgbot-verify** | `plugins/tgbot-verify/` | TG Bot 小芽精灵（Docker 部署） |
| **zibll-media-library** | `plugins/zibll-media-library/` | 前台媒体库管理 |

## 主题更新后恢复

```bash
# 1. 查看 xingxy patches 目录中的补丁文档
cat xingxy/patches/README.md

# 2. 对比当前修改与 Git 记录
cd /www/wwwroot/xingxy.manyuzo.com/wp-content/themes/panda
git diff HEAD

# 3. 按补丁文档逐一恢复
```

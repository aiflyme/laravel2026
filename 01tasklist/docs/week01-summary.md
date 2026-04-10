# Week 01 总结 · Apr 6–10, 2026

**学习天数：** 6天（Day 1–6，含复习日）
**整体节奏：** 超前计划，基础概念扎实，问题质量高
**本周项目：** 01tasklist（PostgreSQL + Laravel 基础结构）

---

## 一、框架基础 ✅ 🔵概念为主，少用到

**Laravel原生**

- MVC 三层职责：Model（数据）/ View（展示）/ Controller（请求协调层，不是业务逻辑层）
- 项目关键目录：`app/` / `resources/views/` / `routes/` / `database/`
- `User extends Authenticatable` = Model + 登录能力，其他 Model 直接 extends Model
- 代码里不要直接用 `env()`，应通过 `config()` 读取（缓存配置后 `env()` 会返回 null）

**Filament对应**

- Filament 替代了 Controller + View，Model 层不变
- 三种工具：Resource（CRUD）/ Page（自定义页）/ Widget（组件）
- Livewire 是 Filament 的底层渲染引擎

**🏭 QMS连接**

- Filament 管理整个 QMS 后台，web.php 几乎是空的

**掌握度：** ✅

---

## 二、路由 ✅ 🔴每天都用

**Laravel原生**

- GET / POST / 带参数 `{id}` / 命名路由
- 目前用闭包写法，Controller 版本是 Week 2 的目标写法

```php
// 闭包写法（当前）
Route::get('/tasks', function () {
    return view('index', ['tasks' => $tasks]);
});

// Controller写法（Week 2 目标）
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
```

```php
// 命名路由 — 生成链接和跳转
route('tasks.index')
route('tasks.show', ['id' => 1])
return redirect()->route('tasks.index');
```

```php
// 兜底路由 — 所有未匹配的请求
Route::fallback(function () {
    return 'Page not found';
});
```

```bash
# 查看所有已注册路由
php artisan route:list
```

**Filament对应**

- 路由由 `AdminPanelProvider` 自动注册，不在 web.php 定义
- `->path('admin')` 设置前缀，`->authMiddleware([])` 挂登录验证

**🏭 QMS连接**

- `app/Providers/Filament/AdminPanelProvider.php` 是路由入口

**掌握度：** ✅

---

## 三、视图（Blade + Layout）⚠️ 🔴每天都用 ← 重点复习

**Laravel原生**

```php
{{-- 条件循环（比 @foreach + @if 更地道）--}}
@forelse ($tasks as $task)
    <p>{{ $task->title }}</p>
@empty
    <p>没有任务</p>
@endforelse

{{-- Layout 继承 --}}
{{-- layouts/app.blade.php --}}
@yield('content')
@stack('scripts')

{{-- 子页面 --}}
@extends('layouts.app')
@section('content')
    内容写这里
@endsection
@push('scripts')
    <script src="..."></script>
@endpush
```

**Filament对应**

- Filament 不用 Blade 模板继承，由 Resource / Pages 自动渲染
- Form / Table / Infolist 替代了手写 Blade 视图

**🏭 QMS连接**

- `resources/views/` 几乎没有文件，页面全由 Filament Schemas 渲染

**掌握度：** ✅（@stack/@push 待实际使用）⚠️

---

## 四、数据库连接 ✅ 🔵一次性配置

**Laravel原生**

- 配置在 `.env`：`DB_CONNECTION=pgsql / DB_HOST / DB_DATABASE`
- `config/database.php` 读取 `.env` 的值

**PostgreSQL vs MySQL**

- PG 选型原因：`array` + `unnest()`（多值字段）/ `JSONB`（可索引）/ 审计能力
- `json` vs `jsonb`：json 存文本，jsonb 存二进制可加索引，查询更快

**🏭 QMS连接**

- `department` 字段目前用 `json`（技术债），应改为 `jsonb`
- `CapaByDepartmentChart` 已经手动 `::jsonb` 强转，改后可删掉

**掌握度：** ✅

---

## 五、Migration + Model 基础 ✅ 🔴每个新功能都用 ← 重点复习

**Migration 命令**

```bash
# 建表
php artisan make:migration create_tasks_table

# 加字段
php artisan make:migration add_description_to_tasks_table

# 删字段
php artisan make:migration remove_description_from_tasks_table

# 执行 / 回滚 / 重建
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh --seed   # 开发常用，DROP所有表再从头跑up()
php artisan migrate:status
```

**`migrate:fresh` vs `migrate:refresh`**

- `fresh`：直接 DROP 所有表，重新跑 `up()`（不管 `down()` 怎么写）
- `refresh`：按顺序调用每个 migration 的 `down()` 再 `up()`（依赖 down() 写对）
- 开发环境推荐 `fresh`，更可靠

**常用字段类型**

```php
$table->id();                              // BIGINT 主键（PG里是BIGSERIAL）
$table->string('title');                   // NOT NULL
$table->string('note')->nullable();        // 允许为空
$table->boolean('done')->default(false);   // 有默认值 = 一定不为空
$table->foreignId('user_id')->constrained(); // 外键（现代写法，自动关联users.id）
$table->timestamps();                      // created_at + updated_at 两个字段
```

**Model 批量赋值保护（Week 2 会用到）**

```php
// Laravel 默认阻止批量赋值，必须在 Model 里声明允许的字段
// 否则 Task::create([...]) 会报错
class Task extends Model
{
    protected $fillable = ['title', 'description', 'completed'];
}
```

**注意**

- PG 不支持 `after()`，不要写
- 已跑过的 migration 不能改，要新建
- 命名空间大小写：`Illuminate\Http\Request`（H 大写），Windows 不报错但 **Linux 会500**

**生成快捷命令**

```bash
php artisan make:model Task -m      # Model + Migration
php artisan make:model Task -mcr    # Model + Migration + Resource Controller（7个RESTful方法）
php artisan make:model Task -mfc    # Model + Migration + Factory + Controller
```

**Filament对应**

- Migration 层 Laravel 和 Filament 完全共用，无区别

**🏭 QMS连接**

- `database/migrations/` 有多个 add_xxx 文件，说明 QMS 是逐步演进的
- `AuditTrail` 表设计：`$timestamps = false`，只有 `created_at`，不可修改删除

**掌握度：** ✅

---

## 六、Filament 架构认知 ⚠️ 🟡QMS开发常用，Week 3-4 深入

**请求链**

```
浏览器
  ↓
web.php（入口）
  ↓
AdminPanelProvider（注册路由 / 中间件 / path前缀）
  ↓
Livewire（实时渲染引擎）
  ↓
Filament Resource
  ├── Pages（ListCapas / CreateCapa / EditCapa）
  ├── Table（列表）
  └── Schemas（Form / Infolist）
        ↕
      Model（Eloquent）
        ↕
       DB（PostgreSQL）
```

**多态关联（MorphTo）**

- 一张表服务多个 Model，靠 `type + id` 动态决定
- QMS 的 `audit_trails` 同时关联 Capa / Deviation 等

**🏭 QMS连接**

- `HasAuditTrail` Trait 监听 Eloquent 事件（created/updated/deleted）
- `AuditTrail` Model 不可改、不可删（应用层保护，DB层是 TODO）

**掌握度：** ✅（概念）⚠️（实操待 Week 3-4）

---

## 七、其他已用工具 ✅ 🟡调试时用

```php
// Collection — Laravel 的数据集合操作
collect($tasks)->firstWhere('id', $id);

// 错误处理 — 返回 HTTP 错误页
abort(404);                          // 简写
abort(Response::HTTP_NOT_FOUND);     // 常量写法
```

```bash
# Tinker — 交互式调试（不好复制粘贴时用文件模式）
php artisan tinker
php artisan tinker tinker.php        # 执行文件
```

**掌握度：** ✅

---

## 八、本周最大收获

1. **CI → Laravel 思维转换**：CI 用 JOIN 拼数据，Laravel 在 Model 定义关系 + `with()` 预加载，不再手写 JOIN
2. **Filament 不是魔法**：它替代了 Controller + View，但 Model / Migration / DB 层和原生 Laravel 完全一样
3. **PostgreSQL 选型有根据**：JSONB / array / 审计能力，不是随便选的

---

## 九、待巩固 / 遗留问题

- ⚠️ `@stack / @push` 还没实际用过，停留在概念
- ⚠️ Eloquent `with()` 只理解原理，Week 2 才真正练手
- ⚠️ `$fillable` 概念已知但 Task Model 尚未配置
- ❌ `department` 字段 json → jsonb 改造（QMS技术债，待处理）
- ❌ Telescope 还没装，Week 2 调试 N+1 时需要

---

## 十、下周预告（Week 2 · Apr 13–19）

**主题：** Eloquent + 表单 + 完成 TaskList CRUD

**与 Week 1 的衔接：**

- Factory + Seeder 会用到 Week 1 建好的 migration
- 表单提交 `Task::create()` 需要先配好 `$fillable`
- Telescope 需要在 Week 2 开始前装好，用来调试 N+1

**重点内容：**

- `all() / find() / where() / first()` 基础查询
- Factory + Seeder 生成假数据
- 表单提交：`@csrf / validate / @error / old()`
- Session / redirect / flash
- 完整 CRUD：列表 + 新增 + 编辑 + 删除 + 分页

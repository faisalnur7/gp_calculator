You’re basically asking for a **gold weight calculator system** (Vori–Ana–Roti–Point). Here’s a clean, practical plan you can use for Excel, Laravel, or any app.

---

# 🧮 Measurement Basics (Bangladesh Standard)

* **1 Vori = 16 Ana**
* **1 Ana = 6 Roti**
* **1 Roti = 10 Point**

👉 So:

* **1 Vori = 16 × 6 × 10 = 960 Point**

---

# 🔢 Core Formula (Convert Everything → Point)

```
Total Point = 
(Vori × 960) +
(Ana × 60) +
(Roti × 10) +
(Point)
```

---

# 🔁 Reverse Formula (Point → Vori, Ana, Roti, Point)

```
Vori = TotalPoint ÷ 960
Remainder = TotalPoint % 960

Ana = Remainder ÷ 60
Remainder = Remainder % 60

Roti = Remainder ÷ 10
Point = Remainder % 10
```

---

# 📊 Example Calculation

Input:

* Vori = 2
* Ana = 5
* Roti = 3
* Point = 7

### Step:

```
= (2 × 960) + (5 × 60) + (3 × 10) + 7
= 1920 + 300 + 30 + 7
= 2257 Point
```

---

# 📘 Excel Sheet Plan

### Columns:

| Vori | Ana | Roti | Point | Total Point |
| ---- | --- | ---- | ----- | ----------- |

### Formula (Total Point column):

```excel
= A2*960 + B2*60 + C2*10 + D2
```

---

# 🔄 Reverse Output Columns

| Total Point | Vori | Ana | Roti | Point |

### Formulas:

```excel
Vori = INT(A2/960)

Ana = INT(MOD(A2,960)/60)

Roti = INT(MOD(A2,60)/10)

Point = MOD(A2,10)
```

---

# 💻 Laravel / Backend Logic Plan

### Function (PHP)

```php
function toPoint($vori, $ana, $roti, $point) {
    return ($vori * 960) + ($ana * 60) + ($roti * 10) + $point;
}

function fromPoint($total) {
    $vori = intdiv($total, 960);
    $rem = $total % 960;

    $ana = intdiv($rem, 60);
    $rem = $rem % 60;

    $roti = intdiv($rem, 10);
    $point = $rem % 10;

    return compact('vori', 'ana', 'roti', 'point');
}
```

---

# 🎯 Features You Can Add

* Auto conversion (live input)
* Gold price per vori → total value
* Input validation (Ana < 16, Roti < 6, Point < 10)
* Dropdown or stepper UI
* Print invoice (jewelry shop ready)

---

If you want, I can:

* Generate a **ready Excel file**
* Build a **Laravel Blade + Controller UI**
* Or make a **JavaScript live calculator** for your website

Just tell me 👍

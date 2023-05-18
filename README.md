# ICT4D NTFPs Project

Intoduction and Motivation: This prototype is to support women farmers/entrepreneurs in Burkina Faso to commercialise non-timber forest products (NTFPs). NTFPs are important for rural development for several reasons: nutritional, environmental, and economical and also for their role in women's empowerment. The challenge is to create a sustainable market for NTFPs whose customers are the Burkina Faso society: the production, processing and marketing of NTFPs is a sustainable economic activity that does not harm the environment but rather promotes the conservation and sustainable use of trees in agro-ecological areas. Women benefit greatly from NTFPs, and working in groups and sharing knowledge opens up new opportunities for the division of labour, marketing and a sense of community. In addition, the idea is valuable because it has the potential to improve the local economy, environment, biodiversity, and food and nutritional values while empowering women.

---
## Prerequisites

```
psycopg2
```
Since we use the ElephantSQL cloud database (https://www.elephantsql.com/), which is based on the PostgresSQL therefore the `psycopg2` is essential, as well as the account information for the database. It also provides a view for the whole structure of the db.

## Deployment

1. Run `db.py` in order to create the database
2. Upload the `.vxml` file to the Voxeo or kasadaka platform
3. Call correspond phone number and type the PIN

---

**Date Created**: 2023/04/15

- Build the basic VXML structure of the menu, market, and informarion page.

**Version 1.0**: 2023/04/30

- Add the French version of the menu, market, and informarion page, and link to the external dataset.

**Version 2.0**: 2023/05/15

- Modify the market and information page, and fix the bugs.

**Version 3.0**: 2023/05/18

- Modify the grammar, in order to run in the kasadaka platform.

Use our application, please call `+31 2 08 08 2848` and enter the PIN: `9990522473`.

The Reference for the content in info.vxml: https://www.banglajol.info/index.php/JHPN/article/view/7856

> Note: Since Voxeo platform is down, so we have to move the file to the kasadaka platform, the old file is stored in the `Voxeo` folder, since we have to change some grammar and statement to run successfully. Unfortunately, we encountered some problems when bootstrapping from `vxml` file to other files, moving from `main_menu.vxml` to `menu_en.vxml` can be transferred, but after that we can't the same statement to move `menu_en.vxml` to `info.vxml` or `market.vxml` file, we tried many ways but can't solve this problem :(, hope you can understand

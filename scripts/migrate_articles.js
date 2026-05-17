// 批量文章分配 - 方案A：接受建议批量移动
const mysql = require('mysql2/promise');

const moves = [
  // 内容数字员工 (111)
  { target: 111, aids: [1737, 1759, 1761, 1762] },
  // 营销数字员工 (112)
  { target: 112, aids: [1740, 1751, 1752, 1756, 1757, 1758] },
  // 客服数字员工 (113)
  { target: 113, aids: [1717, 1718, 1307, 1310] },
  // 大模型 (121)
  { target: 121, aids: [1813, 1814, 1815] },
  // 智能体 (122)
  { target: 122, aids: [1744, 1772, 1806, 1807, 1812, 1816] },
  // AI应用 (123)
  { target: 123, aids: [1791, 1782, 1808, 1779] },
  // PLM系统 (131)
  { target: 131, aids: [127, 1691, 1692, 1702, 1703, 1704, 1705, 1706, 1709, 1710, 1711, 1712, 1713, 1714, 1716, 1725, 1727, 1728, 1764, 1787, 1796, 1797, 1798, 1799, 1800, 1801, 1802, 1803, 1804, 1805] },
  // MES系统 (132)
  { target: 132, aids: [1693, 1694, 1696, 1697, 1698, 1784, 1785, 1786] },
  // 工业软件 (133)
  { target: 133, aids: [1290, 1292, 1313, 1730, 1731, 1735, 1736, 1738, 1739, 1742, 1743, 1747, 1749, 1750, 1760, 1763, 1766, 1768, 1769, 1770, 1771, 1773, 1774, 1775, 1776, 1777, 1778, 1781, 1788, 1789, 1790, 1792, 1793, 1794, 1795, 1809, 1793, 1794] },
];

async function migrate() {
  const conn = await mysql.createConnection({
    host: '82.156.40.94',
    user: 'eastaiai',
    password: 'alibaba',
    database: 'eastaiai',
    multipleStatements: true
  });

  let total = 0;
  for (const m of moves) {
    const [rows] = await conn.query(
      `UPDATE lvbo_article SET typeid=? WHERE aid IN (${m.aids.join(',')})`,
      [m.target]
    );
    console.log(`→ typeid ${m.target} (${m.aids.length}篇): affected ${rows.affectedRows}`);
    total += rows.affectedRows;
  }
  console.log(`\n总计移动 ${total} 篇文章`);
  await conn.end();
}

migrate().catch(console.error);
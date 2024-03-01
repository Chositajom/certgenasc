<?php
/**
 * @filesource modules/repair/modules/operator.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Repair\operator;

/**
 * อ่านรายชื่อคุณครูทั้งหมด
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\KBase
{
    /**
     * @var mixed
     */
    private $operators;

    /**
     * Query รายชื่อคุณครู
     *
     * @return array
     */
    public static function all()
    {
        return \Kotchasan\Model::createQuery()
            ->select('id', 'name')
            ->from('user')
            ->where(array(
                array('active', 1),
                array('permission', 'LIKE', '%,can_repair,%')
            ))
            ->order('id')
            ->toArray()
            ->execute();
    }

    /**
     * อ่านรายชื่อคุณครู
     *
     * @return static
     */
    public static function create()
    {
        $obj = new static;
        $obj->operators = [];
        foreach (self::all() as $item) {
            $obj->operators[$item['id']] = $item['name'];
        }
        return $obj;
    }

    /**
     * อ่านรายชื่อคุณครูสำหรับใส่ลงใน select
     *
     * @return array
     */
    public function toSelect()
    {
        return $this->operators;
    }

    /**
     * อ่านชื่อช่างที่ $id
     *
     * @param int $id
     *
     * @return string
     */
    public function get($id)
    {
        return isset($this->operators[$id]) ? $this->operators[$id] : '';
    }
}

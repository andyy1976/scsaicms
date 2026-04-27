<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 编辑用户
 *
 * @link typecho
 * @package Widget
 * @copyright Copyright (c) 2008 Typecho team (http://www.typecho.org)
 * @license GNU General Public License 2.0
 * @version $Id$
 */

/**
 * 编辑用户组件
 *
 * @link typecho
 * @package Widget
 * @copyright Copyright (c) 2008 Typecho team (http://www.typecho.org)
 * @license GNU General Public License 2.0
 */
class Widget_Users_Edit extends Widget_Abstract_Users implements Widget_Interface_Do
{
    /**
     * 获取页面偏移的URL Query
     *
     * @access protected
     * @param integer $id 用户id
     * @return string
     */
    protected function getPageOffsetQuery($id)
    {
        return 'page=' . $this->getPageOffset('id', $id);
    }

    /**
     * 执行函数
     *
     * @access public
     * @return void
     */
    public function execute()
    {
        /** 管理员以上权限 */
        $this->user->pass('administrator');

        /** 更新模式 */
        if (($this->request->id && 'delete' != $this->request->do) || 'update' == $this->request->do) {
            $this->db->fetchRow($this->select()
            ->where('id = ?', $this->request->id)->limit(1), array($this, 'push'));

            if (!$this->have()) {
                throw new Typecho_Widget_Exception(_t('用户不存在'), 404);
            }
        }
    }

    /**
     * 获取菜单标题
     *
     * @access public
     * @return string
     */
    public function getMenuTitle()
    {
        return _t('编辑用户 %s', $this->name);
    }

    /**
     * 判断用户是否存在
     *
     * @access public
     * @param integer $id 用户主键
     * @return boolean
     */
    public function userExists($id)
    {
        $user = $this->db->fetchRow($this->db->select()
        ->from('table.member')
        ->where('id = ?', $id)->limit(1));

        return !empty($user);
    }

    /**
     * 生成表单
     *
     * @access public
     * @param string $action 表单动作
     * @return Typecho_Widget_Helper_Form
     */
    public function form($action = NULL)
    {
        /** 构建表格 */
        $form = new Typecho_Widget_Helper_Form($this->security->getIndex('/action/users-edit'),
        Typecho_Widget_Helper_Form::POST_METHOD);

        /** 用户名称 */
        $username = new Typecho_Widget_Helper_Form_Element_Text('username', NULL, NULL, _t('用户名 *'), _t('此用户名将作为用户登录时所用的名称.')
            . '<br />' . _t('请不要与系统中现有的用户名重复.'));
        $form->addInput($username);

        /** 电子邮箱地址 */
        $email = new Typecho_Widget_Helper_Form_Element_Text('email', NULL, NULL, _t('电子邮箱地址 *'), _t('电子邮箱地址将作为此用户的主要联系方式.')
            . '<br />' . _t('请不要与系统中现有的电子邮箱地址重复.'));
        $form->addInput($email);

        /** 用户昵称 */
        $screenName = new Typecho_Widget_Helper_Form_Element_Text('screenName', NULL, NULL, _t('用户昵称'), _t('用户昵称可以与用户名不同, 用于前台显示.')
            . '<br />' . _t('如果你将此项留空, 将默认使用用户名.'));
        $form->addInput($screenName);

        /** 用户密码 */
        $userpwd = new Typecho_Widget_Helper_Form_Element_Password('userpwd', NULL, NULL, _t('用户密码'), _t('为此用户分配一个密码.')
            . '<br />' . _t('建议使用特殊字符与字母、数字的混编样式,以增加系统安全性.'));
        $userpwd->input->setAttribute('class', 'w-60');
        $form->addInput($userpwd);

        /** 用户密码确认 */
        $confirm = new Typecho_Widget_Helper_Form_Element_Password('confirm', NULL, NULL, _t('用户密码确认'), _t('请确认你的密码, 与上面输入的密码保持一致.'));
        $confirm->input->setAttribute('class', 'w-60');
        $form->addInput($confirm);

        /** 个人主页地址 */
        $url = new Typecho_Widget_Helper_Form_Element_Text('url', NULL, NULL, _t('个人主页地址'), _t('此用户的个人主页地址, 请用 <code>http://</code> 开头.'));
        $form->addInput($url);

        /** 用户组 */
        $group =  new Typecho_Widget_Helper_Form_Element_Select('group', array('subscriber' => _t('关注者'),
                'contributor' => _t('贡献者'), 'editor' => _t('编辑'), 'administrator' => _t('管理员')),
                NULL, _t('用户组'), _t('不同的用户组拥有不同的权限.')
            . '<br />' . _t('具体的权限分配表请<a href="http://docs.typecho.org/develop/acl">参考这里</a>.'));
        $form->addInput($group);

        /** 用户动作 */
        $do = new Typecho_Widget_Helper_Form_Element_Hidden('do');
        $form->addInput($do);

        /** 用户主键 */
        $id = new Typecho_Widget_Helper_Form_Element_Hidden('id');
        $form->addInput($id);

        /** 提交按钮 */
        $submit = new Typecho_Widget_Helper_Form_Element_Submit();
        $submit->input->setAttribute('class', 'btn primary');
        $form->addItem($submit);

        if (NULL != $this->request->id) {
            $submit->value(_t('编辑用户'));
            $username->value($this->username);
            $screenName->value($this->screenName);
            $url->value($this->url);
            $email->value($this->email);
            $group->value($this->group);
            $do->value('update');
            $id->value($this->id);
            $_action = 'update';
        } else {
            $submit->value(_t('增加用户'));
            $do->value('insert');
            $_action = 'insert';
        }

        if (empty($action)) {
            $action = $_action;
        }

        /** 给表单增加规则 */
        if ('insert' == $action || 'update' == $action) 
        {
            $screenName->addRule(array($this, 'screenNameExists'), _t('昵称已经存在'));
            $screenName->addRule('xssCheck', _t('请不要在昵称中使用特殊字符'));
            $url->addRule('url', _t('个人主页地址格式错误'));
            $email->addRule('required', _t('必须填写电子邮箱'));
            $email->addRule(array($this, 'mailExists'), _t('电子邮箱地址已经存在'));
            $email->addRule('email', _t('电子邮箱格式错误'));
            $userpwd->addRule('minLength', _t('为了保证账户安全, 请输入至少六位的密码'), 6);
            $confirm->addRule('confirm', _t('两次输入的密码不一致'), 'userpwd');
        }

        if ('insert' == $action) 
        {
            $username->addRule('required', _t('必须填写用户名称'));
            $username->addRule('xssCheck', _t('请不要在用户名中使用特殊字符'));
            $username->addRule(array($this, 'nameExists'), _t('用户名已经存在'));
            $userpwd->label(_t('用户密码 *'));
            $confirm->label(_t('用户密码确认 *'));
            $userpwd->addRule('required', _t('必须填写密码'));
        }

        if ('update' == $action) {
            $username->input->setAttribute('disabled', 'disabled');
            $id->addRule('required', _t('用户主键不存在'));
            $id->addRule(array($this, 'userExists'), _t('用户不存在'));
        }

        return $form;
    }

    /**
     * 增加用户
     *
     * @access public
     * @return void
     */
    public function insertUser()
    {
        if ($this->form('insert')->validate()) {
            $this->response->goBack();
        }

        $hasher = new PasswordHash(8, true);

        /** 取出数据 */
        $user = $this->request->from('username', 'email', 'screenName', 'userpwd', 'url', 'group');
        
        $user['screenName'] = empty($user['screenName']) ? $user['username'] : $user['screenName'];
        $user['userpwd'] = $hasher->HashPassword($user['userpwd']);
        $user['created'] = $this->options->time;

        /** 插入数据 */
        $user['id'] = $this->insert($user);

        /** 设置高亮 */
        $this->widget('Widget_Notice')->highlight('user-' . $user['id']);

        /** 提示信息 */
        $this->widget('Widget_Notice')->set(_t('用户 %s 已经被增加', $user['screenName']), 'success');

        /** 转向原页 */
        $this->response->redirect(Typecho_Common::url('manage-users.php', $this->options->adminUrl));
    }

    /**
     * 更新用户
     *
     * @access public
     * @return void
     */
    public function updateUser()
    {
        if ($this->form('update')->validate()) {
            $this->response->goBack();
        }

        /** 取出数据 */
        $user = $this->request->from('email', 'screenName', 'userpwd', 'url', 'group');
        $user['screenName'] = empty($user['screenName']) ? $user['username'] : $user['screenName'];
        if (empty($user['userpwd'])) {
            unset($user['userpwd']);
        } else {
            $hasher = new PasswordHash(8, true);
            $user['userpwd'] = $hasher->HashPassword($user['userpwd']);
        }

        /** 更新数据 */
        $this->update($user, $this->db->sql()->where('id = ?', $this->request->id));

        /** 设置高亮 */
        $this->widget('Widget_Notice')->highlight('user-' . $this->request->id);

        /** 提示信息 */
        $this->widget('Widget_Notice')->set(_t('用户 %s 已经被更新', $user['screenName']), 'success');

        /** 转向原页 */
        $this->response->redirect(Typecho_Common::url('manage-users.php?' .
        $this->getPageOffsetQuery($this->request->id), $this->options->adminUrl));
    }

    /**
     * 删除用户
     *
     * @access public
     * @return void
     */
    public function deleteUser()
    {
        $users = $this->request->filter('int')->getArray('id');
        $masterUserId = $this->db->fetchObject($this->db->select(array('MIN(id)' => 'num'))->from('table.member'))->num;
        $deleteCount = 0;

        foreach ($users as $user) {
            if ($masterUserId == $user || $user == $this->user->id) {
                continue;
            }

            if ($this->delete($this->db->sql()->where('id = ?', $user))) {
                $deleteCount ++;
            }
        }

        /** 提示信息 */
        $this->widget('Widget_Notice')->set($deleteCount > 0 ? _t('用户已经删除') : _t('没有用户被删除'),
        $deleteCount > 0 ? 'success' : 'notice');

        /** 转向原页 */
        $this->response->redirect(Typecho_Common::url('manage-users.php', $this->options->adminUrl));
    }

    /**
     * 入口函数
     *
     * @access public
     * @return void
     */
    public function action()
    {
        $this->user->pass('administrator');
        $this->security->protect();
        $this->on($this->request->is('do=insert'))->insertUser();
        $this->on($this->request->is('do=update'))->updateUser();
        $this->on($this->request->is('do=delete'))->deleteUser();
        $this->response->redirect($this->options->adminUrl);
    }
}

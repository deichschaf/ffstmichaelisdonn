import type { Meta, StoryObj } from '@storybook/react';
import BurgerMenu from './index';

const meta: Meta<typeof BurgerMenu> = {
  title: 'Shared/Atoms/BurgerMenu',
  component: BurgerMenu,
};
export default meta;
type Story = StoryObj<typeof BurgerMenu>;
export const Primary: Story = {
  render: () => <BurgerMenu naviOpen={false} onClick={() => alert('wird geöffent')} />,
};

export const Secondary: Story = {
  render: () => <BurgerMenu naviOpen onClick={() => alert('wird geschlossen')} />,
};

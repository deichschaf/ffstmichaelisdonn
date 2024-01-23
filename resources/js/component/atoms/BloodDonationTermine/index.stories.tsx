import type { Meta, StoryObj } from '@storybook/react';
import BloodDonationTermine from './index';
import { StorybookData } from './index.data';

const meta: Meta<typeof BloodDonationTermine> = {
  title: 'Shared/Atoms/BloodDonationTermine',
  component: BloodDonationTermine,
};
export default meta;
type Story = StoryObj<typeof BloodDonationTermine>;
export const Primary: Story = {
  render: () => <BloodDonationTermine data={StorybookData} />,
};

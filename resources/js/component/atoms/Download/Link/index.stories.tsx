import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import DownloadLink from './index';

const meta: Meta<typeof DownloadLink> = {
  title: 'Shared/Atoms/Download/Link',
  component: DownloadLink,
};
export default meta;
type Story = StoryObj<typeof DownloadLink>;
export const Primary: Story = {
  render: () => <DownloadLink />,
};

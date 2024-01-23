import React from 'react';
import { composeStories } from '@storybook/testing-react';
import { render } from '@testing-library/react';
import * as BloodDonationTermineStories from './index.stories';

const { Primary } = composeStories(BloodDonationTermineStories);

describe('Atoms - BloodDonation Termine', () => {
  it('renders correctly', () => {
    render(<Primary />);
  });
});

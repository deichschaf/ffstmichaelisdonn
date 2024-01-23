// Auto-generated do not edit

/* eslint-disable import/no-extraneous-dependencies */
/* eslint-disable no-undef */
import React from 'react';
import renderer from 'react-test-renderer';
import app_app from '../app_app';

describe('app_app test', () => {
  it('app_app should match snapshot', () => {
    const component = renderer.create(<app_app />);
    const tree = component.toJSON();
    expect(tree).toMatchSnapshot();
  });
});

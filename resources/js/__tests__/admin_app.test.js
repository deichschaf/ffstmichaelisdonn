// Auto-generated do not edit

/* eslint-disable import/no-extraneous-dependencies */
/* eslint-disable no-undef */
import React from 'react';
import renderer from 'react-test-renderer';
import admin_app from '../admin_app';

describe('admin_app test', () => {
  it('admin_app should match snapshot', () => {
    const component = renderer.create(<admin_app />);
    const tree = component.toJSON();
    expect(tree).toMatchSnapshot();
  });
});

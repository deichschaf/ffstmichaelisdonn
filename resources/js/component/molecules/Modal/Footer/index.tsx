import React from 'react';
import { ModalFooterProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';

const ModalFooter: React.FC<React.PropsWithChildren<ModalFooterProps>> = (
  props: ModalFooterProps,
): JSX.Element => (
  <div className="modal-footer">
    <Button type="button" className="btn btn-default" data-dismiss="modal" label="Close" />
    <Button type="button" className="btn btn-primary" label="Save changes" />
  </div>
);
export default ModalFooter;

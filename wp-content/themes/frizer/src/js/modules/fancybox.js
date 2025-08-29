import { Fancybox } from "@fancyapps/ui/dist/fancybox/";

export function fancyBoxGallery() {
  Fancybox.bind('[data-fancybox="gallery"]', {});

  Fancybox.bind('[data-fancybox="filtering-gallery"]', {});
}